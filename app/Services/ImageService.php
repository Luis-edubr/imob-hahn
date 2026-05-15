<?php

namespace App\Services;

use App\Models\MediaAsset;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ImageService
{
    private const MAX_DIMENSION = 2560;
    private const WEBP_QUALITY = 82;
    private const SIGNED_URL_TTL_MINUTES = 30;

    private readonly ImageManager $imageManager;

    public function __construct(?ImageManager $imageManager = null)
    {
        $this->imageManager = $imageManager ?? ImageManager::gd();
    }

    public function upload(UploadedFile $file): MediaAsset
    {
        $image = $this->imageManager->read($file->getRealPath());
        $image->scaleDown(width: self::MAX_DIMENSION, height: self::MAX_DIMENSION);

        $encoded = $image->toWebp(self::WEBP_QUALITY);
        $binary = $encoded->toString();

        $checksum = hash('sha256', $binary);

        $existing = MediaAsset::query()
            ->where('checksum', $checksum)
            ->where('mime', 'image/webp')
            ->first();

        if ($existing) {
            return $existing;
        }

        $path = sprintf('media/%s/%s.webp', now()->format('Y/m'), Str::uuid()->toString());

        Storage::disk('local')->put($path, $binary);

        return MediaAsset::query()->create([
            'disk' => 'local',
            'path' => $path,
            'mime' => 'image/webp',
            'size_bytes' => $encoded->size(),
            'width' => $image->width(),
            'height' => $image->height(),
            'original_name' => $file->getClientOriginalName(),
            'checksum' => $checksum,
        ]);
    }

    public function url(MediaAsset $asset, int $ttlMinutes = self::SIGNED_URL_TTL_MINUTES): string
    {
        return URL::temporarySignedRoute('media.show', now()->addMinutes($ttlMinutes), [
            'mediaAsset' => $asset->id,
        ]);
    }

    public function downloadUrl(MediaAsset $asset, int $ttlMinutes = self::SIGNED_URL_TTL_MINUTES): string
    {
        return URL::temporarySignedRoute('media.download', now()->addMinutes($ttlMinutes), [
            'mediaAsset' => $asset->id,
        ]);
    }

    public function stream(MediaAsset $asset): Response
    {
        $disk = Storage::disk($asset->disk);

        abort_unless($disk->exists($asset->path), 404);

        $etag = '"' . $asset->checksum . '"';
        $lastModified = $asset->updated_at?->toRfc7231String() ?? now()->toRfc7231String();

        if (request()->header('If-None-Match') === $etag) {
            return response('', 304, [
                'ETag' => $etag,
                'Last-Modified' => $lastModified,
                'Cache-Control' => 'public, max-age=3600',
            ]);
        }

        return response($disk->get($asset->path), 200, [
            'Content-Type' => $asset->mime,
            'Content-Length' => (string) $asset->size_bytes,
            'Cache-Control' => 'public, max-age=3600',
            'ETag' => $etag,
            'Last-Modified' => $lastModified,
        ]);
    }

    public function download(MediaAsset $asset): StreamedResponse
    {
        $disk = Storage::disk($asset->disk);

        abort_unless($disk->exists($asset->path), 404);

        $filename = pathinfo($asset->original_name, PATHINFO_FILENAME) . '.webp';

        return $disk->download($asset->path, $filename, [
            'Content-Type' => $asset->mime,
        ]);
    }
}

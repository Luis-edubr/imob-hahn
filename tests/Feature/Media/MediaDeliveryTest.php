<?php

namespace Tests\Feature\Media;

use App\Models\MediaAsset;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class MediaDeliveryTest extends TestCase
{
    use RefreshDatabase;

    public function test_signed_media_url_can_stream_image(): void
    {
        Storage::fake('local');

        Storage::disk('local')->put('media/2026/05/photo.webp', 'binary-webp-content');

        $asset = MediaAsset::query()->create([
            'disk' => 'local',
            'path' => 'media/2026/05/photo.webp',
            'mime' => 'image/webp',
            'size_bytes' => strlen('binary-webp-content'),
            'width' => 800,
            'height' => 600,
            'original_name' => 'photo.webp',
            'checksum' => hash('sha256', 'binary-webp-content'),
        ]);

        $url = URL::temporarySignedRoute('media.show', now()->addMinutes(30), ['mediaAsset' => $asset->id]);

        $response = $this->get($url);

        $response->assertOk();
        $response->assertHeader('Content-Type', 'image/webp');
    }

    public function test_expired_signed_media_url_is_rejected(): void
    {
        Storage::fake('local');

        Storage::disk('local')->put('media/2026/05/photo.webp', 'binary-webp-content');

        $asset = MediaAsset::query()->create([
            'disk' => 'local',
            'path' => 'media/2026/05/photo.webp',
            'mime' => 'image/webp',
            'size_bytes' => strlen('binary-webp-content'),
            'width' => 800,
            'height' => 600,
            'original_name' => 'photo.webp',
            'checksum' => hash('sha256', 'binary-webp-content'),
        ]);

        $url = URL::temporarySignedRoute('media.show', now()->subMinute(), ['mediaAsset' => $asset->id]);

        $this->get($url)->assertForbidden();
    }

    public function test_signed_download_url_can_download_image(): void
    {
        Storage::fake('local');

        Storage::disk('local')->put('media/2026/05/photo.webp', 'binary-webp-content');

        $asset = MediaAsset::query()->create([
            'disk' => 'local',
            'path' => 'media/2026/05/photo.webp',
            'mime' => 'image/webp',
            'size_bytes' => strlen('binary-webp-content'),
            'width' => 800,
            'height' => 600,
            'original_name' => 'photo.jpg',
            'checksum' => hash('sha256', 'binary-webp-content'),
        ]);

        $url = URL::temporarySignedRoute('media.download', now()->addMinutes(30), ['mediaAsset' => $asset->id]);

        $response = $this->get($url);

        $response->assertOk();
        $response->assertHeader('Content-Type', 'image/webp');
    }
}

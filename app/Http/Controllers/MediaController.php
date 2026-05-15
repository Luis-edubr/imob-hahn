<?php

namespace App\Http\Controllers;

use App\Models\MediaAsset;
use App\Services\ImageService;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MediaController extends Controller
{
    public function show(MediaAsset $mediaAsset, ImageService $imageService): Response
    {
        return $imageService->stream($mediaAsset);
    }

    public function download(MediaAsset $mediaAsset, ImageService $imageService): StreamedResponse
    {
        return $imageService->download($mediaAsset);
    }
}

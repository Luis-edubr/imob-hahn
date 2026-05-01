<?php

use App\Models\ContentAsset;
use App\Models\ContentText;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

if (! function_exists('text')) {
    function text(string $alias, ?string $default = null): ?string
    {
        return ContentText::query()
            ->where('alias', $alias)
            ->value('content') ?? $default;
    }
}

if (! function_exists('dbAsset')) {
    function dbAsset(string $alias, ?string $default = null): ?string
    {
        $path = ContentAsset::query()
            ->where('alias', $alias)
            ->value('path');

        if (! $path) {
            return $default;
        }

        if (Str::startsWith($path, ['http://', 'https://', '/', 'data:'])) {
            return $path;
        }

        return Storage::url($path);
    }
}
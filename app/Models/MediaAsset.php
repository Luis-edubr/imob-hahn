<?php

namespace App\Models;

use App\Services\ImageService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MediaAsset extends Model
{
    use HasFactory;

    protected $fillable = [
        'disk',
        'path',
        'mime',
        'size_bytes',
        'width',
        'height',
        'original_name',
        'checksum',
    ];

    protected $casts = [
        'size_bytes' => 'integer',
        'width' => 'integer',
        'height' => 'integer',
    ];

    public function propertyImages(): HasMany
    {
        return $this->hasMany(PropertyImage::class);
    }

    public function getUrlAttribute(): string
    {
        return app(ImageService::class)->url($this);
    }

    public function getDownloadUrlAttribute(): string
    {
        return app(ImageService::class)->downloadUrl($this);
    }
}

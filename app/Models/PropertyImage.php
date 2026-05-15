<?php

namespace App\Models;

use App\Services\ImageService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class PropertyImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'media_asset_id',
        'disk',
        'path',
        'alt_text',
        'sort_order',
        'is_cover',
    ];

    protected $casts = [
        'media_asset_id' => 'integer',
        'sort_order' => 'integer',
        'is_cover' => 'boolean',
    ];

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function mediaAsset(): BelongsTo
    {
        return $this->belongsTo(MediaAsset::class);
    }

    public function scopeCover($query)
    {
        return $query->where('is_cover', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('is_cover', 'desc')->orderBy('sort_order');
    }

    public function isCover(): bool
    {
        return (bool) $this->is_cover;
    }

    public function getUrlAttribute(): ?string
    {
        if ($this->mediaAsset) {
            return app(ImageService::class)->url($this->mediaAsset);
        }

        if (blank($this->path)) {
            return null;
        }

        if ($this->disk === 'public') {
            return asset('storage/' . ltrim($this->path, '/'));
        }

        try {
            return Storage::disk($this->disk)->url($this->path);
        } catch (\Throwable $e) {
            return asset($this->path);
        }
    }

    public function getDownloadUrlAttribute(): ?string
    {
        if (! $this->mediaAsset) {
            return null;
        }

        return app(ImageService::class)->downloadUrl($this->mediaAsset);
    }
}

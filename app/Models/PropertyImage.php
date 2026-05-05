<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'disk',
        'path',
        'alt_text',
        'sort_order',
        'is_cover',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'is_cover' => 'boolean',
    ];

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
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

    public function getUrlAttribute(): string
    {
        return $this->disk === 'public'
            ? asset('storage/' . ltrim($this->path, '/'))
            : asset($this->path);
    }
}

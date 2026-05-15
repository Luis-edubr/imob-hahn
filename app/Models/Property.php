<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use App\Models\Amenity;
use App\Models\PropertyImage;

class Property extends Model
{
    use HasFactory, SoftDeletes;

    public const PROPERTY_TYPE_HOUSE = 'casa';
    public const PROPERTY_TYPE_APARTMENT = 'apartamento';
    public const PROPERTY_TYPE_LAND = 'terreno';
    public const PROPERTY_TYPE_COMMERCIAL = 'comercial';
    public const PROPERTY_TYPE_RURAL = 'rural';
    public const PROPERTY_TYPE_OFFICE = 'sala_comercial';

    public const STATUS_DRAFT = 'draft';
    public const STATUS_PUBLISHED = 'published';
    public const STATUS_PAUSED = 'paused';
    public const STATUS_SOLD = 'sold';
    public const STATUS_RENTED = 'rented';

    public const TRANSACTION_SALE = 'sale';
    public const TRANSACTION_RENT = 'rent';
    public const TRANSACTION_SEASON = 'season';

    public static function propertyTypeOptions(): array
    {
        return [
            self::PROPERTY_TYPE_HOUSE => 'Casa',
            self::PROPERTY_TYPE_APARTMENT => 'Apartamento',
            self::PROPERTY_TYPE_LAND => 'Terreno',
            self::PROPERTY_TYPE_COMMERCIAL => 'Comercial',
            self::PROPERTY_TYPE_RURAL => 'Rural',
            self::PROPERTY_TYPE_OFFICE => 'Sala Comercial',
        ];
    }

    public static function transactionTypeOptions(): array
    {
        return [
            self::TRANSACTION_SALE => 'Venda',
            self::TRANSACTION_RENT => 'Aluguel',
            self::TRANSACTION_SEASON => 'Temporada',
        ];
    }

    public static function statusOptions(): array
    {
        return [
            self::STATUS_DRAFT => 'Rascunho',
            self::STATUS_PUBLISHED => 'Publicado',
            self::STATUS_PAUSED => 'Pausado',
            self::STATUS_SOLD => 'Vendido',
            self::STATUS_RENTED => 'Alugado',
        ];
    }

    protected $fillable = [
        'code',
        'slug',
        'title',
        'property_type',
        'transaction_type',
        'status',
        'short_description',
        'description',
        'price',
        'price_sale',
        'price_rent',
        'condo_fee',
        'iptu_value',
        'total_area',
        'built_area',
        'land_area',
        'bedrooms',
        'suites',
        'bathrooms',
        'half_bathrooms',
        'rooms',
        'garages',
        'parking_spaces',
        'floors',
        'furnished',
        'featured',
        'highlight_home',
        'highlight_sale',
        'highlight_rent',
        'weekly_deal',
        'active',
        'postal_code',
        'street',
        'number',
        'complement',
        'district',
        'city',
        'state',
        'country',
        'location_label',
        'maps_url',
        'latitude',
        'longitude',
        'cover_image_path',
        'cover_image_alt',
        'video_url',
        'virtual_tour_url',
        'published_at',
    ];

    protected $casts = [
        'price' => 'integer',
        'price_sale' => 'integer',
        'price_rent' => 'integer',
        'condo_fee' => 'integer',
        'iptu_value' => 'integer',
        'total_area' => 'decimal:2',
        'built_area' => 'decimal:2',
        'land_area' => 'decimal:2',
        'bedrooms' => 'integer',
        'suites' => 'integer',
        'bathrooms' => 'integer',
        'half_bathrooms' => 'integer',
        'rooms' => 'integer',
        'garages' => 'integer',
        'parking_spaces' => 'integer',
        'floors' => 'integer',
        'furnished' => 'boolean',
        'featured' => 'boolean',
        'highlight_home' => 'boolean',
        'highlight_sale' => 'boolean',
        'highlight_rent' => 'boolean',
        'weekly_deal' => 'boolean',
        'active' => 'boolean',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'published_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::saving(function (Property $property): void {
            if (blank($property->slug) && filled($property->title)) {
                $property->slug = Str::slug($property->title);
            }

            if (blank($property->location_label)) {
                $property->location_label = $property->full_location;
            }
        });
    }

    public function images(): HasMany
    {
        return $this->hasMany(PropertyImage::class)->orderBy('sort_order');
    }

    public function coverImage(): HasMany
    {
        return $this->hasMany(PropertyImage::class)->where('is_cover', true)->limit(1);
    }

    public function amenities(): BelongsToMany
    {
        return $this->belongsToMany(Amenity::class)->withTimestamps();
    }

    public function publishedScope($query)
    {
        return $query->where('status', self::STATUS_PUBLISHED)->where('active', true);
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopePublished($query)
    {
        return $query->where('status', self::STATUS_PUBLISHED)->where('active', true);
    }

    public function scopeForSale($query)
    {
        return $query->where('transaction_type', self::TRANSACTION_SALE);
    }

    public function scopeForRent($query)
    {
        return $query->where('transaction_type', self::TRANSACTION_RENT);
    }

    public function scopeSeasonal($query)
    {
        return $query->where('transaction_type', self::TRANSACTION_SEASON);
    }

    public function isPublished(): bool
    {
        return $this->status === self::STATUS_PUBLISHED && (bool) $this->active;
    }

    public function isFeatured(): bool
    {
        return (bool) $this->featured;
    }

    public function isForSale(): bool
    {
        return $this->transaction_type === self::TRANSACTION_SALE;
    }

    public function isForRent(): bool
    {
        return $this->transaction_type === self::TRANSACTION_RENT;
    }

    public function isSeasonal(): bool
    {
        return $this->transaction_type === self::TRANSACTION_SEASON;
    }

    public function hasAmenity(string $amenityName): bool
    {
        return $this->relationLoaded('amenities')
            ? $this->amenities->contains(fn (Amenity $amenity) => Str::lower($amenity->name) === Str::lower($amenityName))
            : $this->amenities()->whereRaw('LOWER(name) = ?', [Str::lower($amenityName)])->exists();
    }

    public function getFullLocationAttribute(): string
    {
        $parts = array_filter([
            $this->street,
            $this->number,
            $this->complement,
            $this->district,
            $this->city,
            $this->state,
        ]);

        return implode(', ', $parts);
    }

    public function getDisplayLocationAttribute(): string
    {
        return $this->location_label ?: $this->full_location;
    }

    public function getPrimaryPriceAttribute(): ?int
    {
        return $this->price ?? $this->price_sale ?? $this->price_rent;
    }

    public function getMainImageAttribute(): ?PropertyImage
    {
        if ($this->relationLoaded('images')) {
            return $this->images->firstWhere('is_cover', true) ?? $this->images->first();
        }

        return $this->images()->where('is_cover', true)->first() ?: $this->images()->orderBy('sort_order')->first();
    }

    public function getTransactionLabelAttribute(): string
    {
        return self::transactionTypeOptions()[$this->transaction_type] ?? ucfirst((string) $this->transaction_type);
    }

    public function getStatusLabelAttribute(): string
    {
        return self::statusOptions()[$this->status] ?? ucfirst((string) $this->status);
    }

    public function getPropertyTypeLabelAttribute(): string
    {
        return self::propertyTypeOptions()[$this->property_type] ?? ucfirst((string) $this->property_type);
    }

    public function formattedPrice(?int $amount = null): string
    {
        $amount ??= $this->primary_price;

        if ($amount === null) {
            return 'Sob consulta';
        }

        return 'R$ ' . number_format($amount / 100, 2, ',', '.');
    }

    public function getFormattedPriceAttribute(): string
    {
        return $this->formattedPrice();
    }

    public function getFormattedSalePriceAttribute(): string
    {
        return $this->formattedPrice($this->price_sale);
    }

    public function getFormattedRentPriceAttribute(): string
    {
        return $this->formattedPrice($this->price_rent);
    }

    public function getFeatureSummaryAttribute(): array
    {
        return array_values(array_filter([
            $this->bedrooms ? $this->bedrooms . ' quarto' . ($this->bedrooms > 1 ? 's' : '') : null,
            $this->suites ? $this->suites . ' suíte' . ($this->suites > 1 ? 's' : '') : null,
            $this->bathrooms ? $this->bathrooms . ' banheiro' . ($this->bathrooms > 1 ? 's' : '') : null,
            $this->rooms ? $this->rooms . ' sala' . ($this->rooms > 1 ? 's' : '') : null,
            $this->garages ? $this->garages . ' garagem' . ($this->garages > 1 ? 's' : '') : null,
            $this->parking_spaces ? $this->parking_spaces . ' vaga' . ($this->parking_spaces > 1 ? 's' : '') : null,
        ]));
    }
}

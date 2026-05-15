<?php

namespace App\Http\Requests\Admin;

use App\Models\Property;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PropertyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $property = $this->route('property');
        $isLandModule = $this->routeIs('admin.lands.*');

        $propertyTypeRule = $isLandModule
            ? ['required', Rule::in(['terreno'])]
            : ['required', 'string', 'max:80', Rule::notIn(['terreno'])];

        return [
            'code' => ['required', 'string', 'max:50', Rule::unique('properties', 'code')->ignore($property)],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('properties', 'slug')->ignore($property)],
            'title' => ['required', 'string', 'max:255'],
            'property_type' => $propertyTypeRule,
            'transaction_type' => ['required', Rule::in(array_keys(Property::transactionTypeOptions()))],
            'status' => ['required', Rule::in(array_keys(Property::statusOptions()))],

            'short_description' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],

            'price' => ['nullable', 'integer', 'min:0'],
            'price_sale' => ['nullable', 'integer', 'min:0'],
            'price_rent' => ['nullable', 'integer', 'min:0'],
            'condo_fee' => ['nullable', 'integer', 'min:0'],
            'iptu_value' => ['nullable', 'integer', 'min:0'],

            'total_area' => ['nullable', 'numeric', 'min:0'],
            'built_area' => ['nullable', 'numeric', 'min:0'],
            'land_area' => ['nullable', 'numeric', 'min:0'],

            'bedrooms' => ['nullable', 'integer', 'min:0', 'max:999'],
            'suites' => ['nullable', 'integer', 'min:0', 'max:999'],
            'bathrooms' => ['nullable', 'integer', 'min:0', 'max:999'],
            'half_bathrooms' => ['nullable', 'integer', 'min:0', 'max:999'],
            'rooms' => ['nullable', 'integer', 'min:0', 'max:999'],
            'garages' => ['nullable', 'integer', 'min:0', 'max:999'],
            'parking_spaces' => ['nullable', 'integer', 'min:0', 'max:999'],
            'floors' => ['nullable', 'integer', 'min:0', 'max:999'],

            'furnished' => ['boolean'],
            'featured' => ['boolean'],
            'highlight_home' => ['boolean'],
            'highlight_sale' => ['boolean'],
            'highlight_rent' => ['boolean'],
            'weekly_deal' => ['boolean'],
            'active' => ['boolean'],

            'postal_code' => ['nullable', 'string', 'max:20'],
            'street' => ['nullable', 'string', 'max:255'],
            'number' => ['nullable', 'string', 'max:20'],
            'complement' => ['nullable', 'string', 'max:255'],
            'district' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'state' => ['nullable', 'string', 'size:2'],
            'country' => ['nullable', 'string', 'max:60'],
            'location_label' => ['nullable', 'string', 'max:255'],
            'maps_url' => ['nullable', 'url', 'max:65535'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],

            'video_url' => ['nullable', 'url', 'max:255'],
            'virtual_tour_url' => ['nullable', 'url', 'max:255'],
            'published_at' => ['nullable', 'date'],

            'amenity_ids' => ['nullable', 'array'],
            'amenity_ids.*' => ['integer', 'exists:amenities,id'],

            'images' => ['required', 'array', 'min:1', 'max:20'],
            'images.*.media_asset_id' => ['nullable', 'integer', 'exists:media_assets,id'],
            'images.*.file' => ['nullable', 'file', 'max:10240', 'mimes:jpeg,jpg,png,webp,avif'],
            'images.*.alt_text' => ['nullable', 'string', 'max:255'],
            'images.*.sort_order' => ['nullable', 'integer', 'min:0', 'max:65535'],
            'images.*.is_cover' => ['nullable', 'boolean'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $images = $this->input('images', []);
            $imageFiles = $this->file('images', []);
            $coverCount = collect($images)->filter(fn (array $image) => !empty($image['is_cover']))->count();

            if ($coverCount === 0) {
                $validator->errors()->add('images', 'Marque uma imagem como capa.');
            }

            if ($coverCount > 1) {
                $validator->errors()->add('images', 'Apenas uma imagem pode ser marcada como capa.');
            }

            $propertyId = $this->route('property')?->id;
            $transactionType = (string) $this->input('transaction_type');
            $highlightSale = $this->boolean('highlight_sale');
            $highlightRent = $this->boolean('highlight_rent');
            $weeklyDeal = $this->boolean('weekly_deal');

            if ($highlightSale && $transactionType !== Property::TRANSACTION_SALE) {
                $validator->errors()->add('highlight_sale', 'Somente imóveis de venda podem entrar no destaque de venda.');
            }

            if ($highlightRent && $transactionType !== Property::TRANSACTION_RENT) {
                $validator->errors()->add('highlight_rent', 'Somente imóveis de aluguel podem entrar no destaque de aluguel.');
            }

            if ($highlightSale && Property::query()->where('highlight_sale', true)->when($propertyId, fn ($query) => $query->whereKeyNot($propertyId))->count() >= 4) {
                $validator->errors()->add('highlight_sale', 'O destaque de venda já atingiu o limite de 4 imóveis.');
            }

            if ($highlightRent && Property::query()->where('highlight_rent', true)->when($propertyId, fn ($query) => $query->whereKeyNot($propertyId))->count() >= 4) {
                $validator->errors()->add('highlight_rent', 'O destaque de aluguel já atingiu o limite de 4 imóveis.');
            }

            if ($weeklyDeal && Property::query()->where('weekly_deal', true)->when($propertyId, fn ($query) => $query->whereKeyNot($propertyId))->exists()) {
                $validator->errors()->add('weekly_deal', 'Já existe uma barbada da semana cadastrada.');
            }

            foreach ($images as $index => $image) {
                $hasAsset = filled($image['media_asset_id'] ?? null);
                $hasFile = isset($imageFiles[$index]['file']) && $imageFiles[$index]['file'];

                if (!$hasAsset && !$hasFile) {
                    $validator->errors()->add("images.$index.file", 'Selecione uma imagem existente ou envie um novo arquivo.');
                }

                if ($hasAsset && $hasFile) {
                    $validator->errors()->add("images.$index.file", 'Use apenas uma origem por linha: biblioteca ou upload.');
                }
            }
        });
    }

    protected function prepareForValidation(): void
    {
        $moneyFields = ['price', 'price_sale', 'price_rent', 'condo_fee', 'iptu_value'];

        $payload = [
            'furnished' => $this->boolean('furnished'),
            'featured' => $this->boolean('featured'),
            'highlight_home' => $this->boolean('highlight_home'),
            'highlight_sale' => $this->boolean('highlight_sale'),
            'highlight_rent' => $this->boolean('highlight_rent'),
            'weekly_deal' => $this->boolean('weekly_deal'),
            'active' => $this->boolean('active'),
        ];

        foreach ($moneyFields as $field) {
            $payload[$field] = $this->normalizeMoney($this->input($field));
        }

        if ($this->routeIs('admin.lands.*')) {
            $payload['property_type'] = 'terreno';
        }

        $payload['state'] = $this->filled('state') ? mb_strtoupper((string) $this->input('state')) : null;

        $images = collect($this->input('images', []))
            ->map(function ($image) {
                return [
                    'media_asset_id' => isset($image['media_asset_id']) && $image['media_asset_id'] !== '' ? (int) $image['media_asset_id'] : null,
                    'alt_text' => isset($image['alt_text']) ? trim((string) $image['alt_text']) : null,
                    'sort_order' => isset($image['sort_order']) && $image['sort_order'] !== '' ? (int) $image['sort_order'] : 0,
                    'is_cover' => filter_var($image['is_cover'] ?? false, FILTER_VALIDATE_BOOLEAN),
                ];
            })
            ->all();

        $payload['images'] = $images;

        $this->merge($payload);
    }

    private function normalizeMoney(mixed $value): ?int
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (is_int($value)) {
            return $value;
        }

        $normalized = preg_replace('/[^\d,\.]/', '', (string) $value) ?? '';

        if ($normalized === '') {
            return null;
        }

        if (str_contains($normalized, ',')) {
            $normalized = str_replace('.', '', $normalized);
            $normalized = str_replace(',', '.', $normalized);
        }

        $floatValue = (float) $normalized;

        return (int) round($floatValue * 100);
    }
}

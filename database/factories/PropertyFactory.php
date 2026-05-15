<?php

namespace Database\Factories;

use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Property>
 */
class PropertyFactory extends Factory
{
    protected $model = Property::class;

    public function definition(): array
    {
        $type = fake()->randomElement(array_keys(Property::propertyTypeOptions()));
        $transaction = fake()->randomElement([Property::TRANSACTION_SALE, Property::TRANSACTION_RENT]);
        $status = fake()->randomElement([Property::STATUS_PUBLISHED, Property::STATUS_PUBLISHED, Property::STATUS_DRAFT]);
        $title = fake()->randomElement(['Casa', 'Apartamento', 'Terreno', 'Sala Comercial']) . ' ' . fake()->streetName();

        $saleValue = $transaction === Property::TRANSACTION_SALE ? fake()->numberBetween(120000, 980000) : null;
        $rentValue = $transaction === Property::TRANSACTION_RENT ? fake()->numberBetween(900, 5800) : null;

        return [
            'code' => 'IMV-' . fake()->unique()->numberBetween(1000, 9999),
            'slug' => Str::slug($title . '-' . Str::lower(Str::random(6))),
            'title' => $title,
            'property_type' => $type,
            'transaction_type' => $transaction,
            'status' => $status,
            'short_description' => fake()->sentence(8),
            'description' => fake()->paragraphs(2, true),
            'price' => $saleValue ? $saleValue * 100 : ($rentValue ? $rentValue * 100 : null),
            'price_sale' => $saleValue ? $saleValue * 100 : null,
            'price_rent' => $rentValue ? $rentValue * 100 : null,
            'condo_fee' => fake()->boolean(35) ? fake()->numberBetween(150, 800) * 100 : null,
            'iptu_value' => fake()->boolean(50) ? fake()->numberBetween(800, 3500) * 100 : null,
            'total_area' => fake()->randomFloat(2, 50, 600),
            'built_area' => fake()->randomFloat(2, 30, 350),
            'land_area' => fake()->randomFloat(2, 50, 1000),
            'bedrooms' => fake()->numberBetween(1, 5),
            'suites' => fake()->numberBetween(0, 3),
            'bathrooms' => fake()->numberBetween(1, 4),
            'half_bathrooms' => fake()->numberBetween(0, 2),
            'rooms' => fake()->numberBetween(1, 3),
            'garages' => fake()->numberBetween(0, 3),
            'parking_spaces' => fake()->numberBetween(0, 3),
            'floors' => fake()->numberBetween(1, 2),
            'furnished' => fake()->boolean(30),
            'featured' => false,
            'highlight_home' => false,
            'highlight_sale' => false,
            'highlight_rent' => false,
            'weekly_deal' => false,
            'active' => true,
            'postal_code' => fake()->postcode(),
            'street' => fake()->streetName(),
            'number' => (string) fake()->buildingNumber(),
            'complement' => fake()->optional(0.3)->secondaryAddress(),
            'district' => fake()->citySuffix(),
            'city' => fake()->randomElement(['Bagé', 'Pelotas', 'Porto Alegre', 'Caxias do Sul']),
            'state' => 'RS',
            'country' => 'Brasil',
            'location_label' => null,
            'maps_url' => null,
            'latitude' => null,
            'longitude' => null,
            'cover_image_path' => null,
            'cover_image_alt' => null,
            'video_url' => null,
            'virtual_tour_url' => null,
            'published_at' => $status === Property::STATUS_PUBLISHED ? now()->subDays(fake()->numberBetween(0, 45)) : null,
        ];
    }
}

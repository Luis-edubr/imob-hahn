<?php

namespace Database\Seeders;

use App\Models\Amenity;
use App\Models\Property;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    public function run(): void
    {
        Property::factory()->count(36)->create();

        $saleHighlights = Property::query()
            ->where('transaction_type', Property::TRANSACTION_SALE)
            ->where('status', Property::STATUS_PUBLISHED)
            ->where('active', true)
            ->latest('published_at')
            ->take(4)
            ->get();

        foreach ($saleHighlights as $property) {
            $property->update([
                'highlight_sale' => true,
                'highlight_home' => true,
                'featured' => true,
            ]);
        }

        $rentHighlights = Property::query()
            ->where('transaction_type', Property::TRANSACTION_RENT)
            ->where('status', Property::STATUS_PUBLISHED)
            ->where('active', true)
            ->latest('published_at')
            ->take(4)
            ->get();

        foreach ($rentHighlights as $property) {
            $property->update([
                'highlight_rent' => true,
                'highlight_home' => true,
                'featured' => true,
            ]);
        }

        $weeklyDeal = Property::query()
            ->where('status', Property::STATUS_PUBLISHED)
            ->where('active', true)
            ->latest('published_at')
            ->first();

        if ($weeklyDeal) {
            $weeklyDeal->update([
                'weekly_deal' => true,
                'highlight_home' => true,
                'featured' => true,
            ]);
        }

        $amenityIds = Amenity::query()->pluck('id');

        if ($amenityIds->isNotEmpty()) {
            Property::query()->inRandomOrder()->take(24)->get()->each(function (Property $property) use ($amenityIds): void {
                $property->amenities()->syncWithoutDetaching(
                    $amenityIds->random(rand(2, min(5, $amenityIds->count())))->all()
                );
            });
        }
    }
}

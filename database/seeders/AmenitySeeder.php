<?php

namespace Database\Seeders;

use App\Models\Amenity;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AmenitySeeder extends Seeder
{
    public function run(): void
    {
        $amenities = [
            'Piscina',
            'Churrasqueira',
            'Lareira',
            'Sacada',
            'Portaria 24h',
            'Elevador',
            'Pátio',
            'Salão de festas',
            'Aceita pets',
        ];

        foreach ($amenities as $name) {
            Amenity::query()->updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'active' => true,
                ]
            );
        }
    }
}

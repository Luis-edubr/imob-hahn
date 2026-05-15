<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'luis@ipsillon.cc'],
            [
                'name' => 'Luis Eduardo',
                'password' => '12345678',
            ]
        );
    }
}

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
        User::query()->updateOrCreate(
            ['email' => 'lidiohendler2021@gmail.com'],
            [
                'name' => 'Lidio Hendler',
                'password' => '12345678',
            ]
        );
    }
}

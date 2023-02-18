<?php

namespace Database\Seeders;

use App\Models\UserSettingApi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('secret'),
        ]);

        \App\Models\UserSettingApi::factory()->create([
            'url' => 'https://devdeni24.vetmanager2.ru',
            'key' => '36819535a844c0c5077f309610386a7b',
        ]);
    }
}

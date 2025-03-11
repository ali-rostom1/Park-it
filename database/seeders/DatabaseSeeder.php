<?php

namespace Database\Seeders;

use App\Models\Parking;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Parking::create([
            'name' => 'Parking 2',
            'location' => 'Parking 2 location',
        ]);
    }
}

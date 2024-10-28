<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Distributor;
use App\Models\Supervisor;
use App\Models\Factory;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run()
    {
        Distributor::create([
            'name' => 'Distributor One',
            'email' => 'distributor1@example.com',
            'password' => Hash::make('distributor123'),
            'phone' => '1234567890',
            'address' => '123, Distributor Street, Distributor City',
        ]);
        Distributor::create([
            'name' => 'Distributor Two',
            'email' => 'distributor2@example.com',
            'password' => Hash::make('distributor123'),
            'phone' => '1234567890',
            'address' => '125, Distributor Street, Distributor City',
        ]);

        Supervisor::create([
            'name' => 'Supervisor One',
            'email' => 'supervisor1@example.com',
            'password' => Hash::make('supervisor123'),
            'phone' => '1234567890',
            'address' => '123, Supervisor Street, Supervisor City',
        ]);

        Factory::create([
            'name' => 'Factory One',
            'email' => 'factory1@example.com',
            'password' => Hash::make('factory123'),
        ]);
    }
}

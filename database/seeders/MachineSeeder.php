<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Machine;
use App\Models\Factory;

class MachineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Retrieve all factories
        $factories = Factory::all();

        // Check if there are factories to associate machines with
        if ($factories->isEmpty()) {
            $this->command->info('No factories found. Please seed factories first.');
            return;
        }

        // Define machine statuses
        $statuses = ['Available', 'Busy', 'Maintenance'];

        foreach ($factories as $factory) {
            // Create a random number of machines for each factory
            $numMachines = rand(5, 10); // Adjust the range as needed

            for ($i = 0; $i < $numMachines; $i++) {
                Machine::create([
                    'factory_id' => $factory->id,
                    'name'       => 'Machine ' . ($i + 1),
                    'status'     => $statuses[array_rand($statuses)],
                ]);
            }
        }

        $this->command->info('Machines seeded successfully.');
    }
}
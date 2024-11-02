<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SparepartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $spareparts = [
            ['name' => 'Brake Pad Set', 'type' => 'motorcycle', 'price' => 120, 'stock' => 50],
            ['name' => 'Fuel Filter', 'type' => 'car', 'price' => 85, 'stock' => 70],
            ['name' => 'Headlight Assembly', 'type' => 'car', 'price' => 320, 'stock' => 25],
            ['name' => 'Spark Plug', 'type' => 'motorcycle', 'price' => 15, 'stock' => 100],
            ['name' => 'Chain and Sprocket Kit', 'type' => 'motorcycle', 'price' => 200, 'stock' => 40],
            ['name' => 'Alternator', 'type' => 'car', 'price' => 450, 'stock' => 10],
            ['name' => 'Exhaust Muffler', 'type' => 'motorcycle', 'price' => 130, 'stock' => 60],
            ['name' => 'Windshield Wiper', 'type' => 'car', 'price' => 25, 'stock' => 90],
            ['name' => 'Battery', 'type' => 'car', 'price' => 150, 'stock' => 15],
            ['name' => 'Oil Filter', 'type' => 'motorcycle', 'price' => 30, 'stock' => 80],
            ['name' => 'Brake Disc', 'type' => 'car', 'price' => 175, 'stock' => 20],
            ['name' => 'Rearview Mirror', 'type' => 'car', 'price' => 45, 'stock' => 35],
            ['name' => 'Handlebar Grips', 'type' => 'motorcycle', 'price' => 25, 'stock' => 100],
            ['name' => 'Clutch Lever', 'type' => 'motorcycle', 'price' => 40, 'stock' => 50],
            ['name' => 'Radiator', 'type' => 'car', 'price' => 400, 'stock' => 12],
            ['name' => 'Piston Rings', 'type' => 'motorcycle', 'price' => 60, 'stock' => 75],
            ['name' => 'Front Brake Caliper', 'type' => 'car', 'price' => 180, 'stock' => 20],
            ['name' => 'Shock Absorber', 'type' => 'motorcycle', 'price' => 110, 'stock' => 60],
            ['name' => 'Drive Belt', 'type' => 'car', 'price' => 130, 'stock' => 45],
            ['name' => 'Gear Shift Lever', 'type' => 'motorcycle', 'price' => 25, 'stock' => 90],
            ['name' => 'Air Filter', 'type' => 'car', 'price' => 60, 'stock' => 50],
            ['name' => 'Valve Cover Gasket', 'type' => 'motorcycle', 'price' => 45, 'stock' => 30],
            ['name' => 'Fuel Pump', 'type' => 'car', 'price' => 220, 'stock' => 15],
            ['name' => 'Carburetor', 'type' => 'motorcycle', 'price' => 95, 'stock' => 25],
            ['name' => 'Timing Belt', 'type' => 'car', 'price' => 190, 'stock' => 10],
            ['name' => 'Throttle Cable', 'type' => 'motorcycle', 'price' => 35, 'stock' => 85],
            ['name' => 'Camshaft', 'type' => 'car', 'price' => 400, 'stock' => 8],
            ['name' => 'Kickstand', 'type' => 'motorcycle', 'price' => 20, 'stock' => 100],
            ['name' => 'Water Pump', 'type' => 'car', 'price' => 250, 'stock' => 12],
            ['name' => 'Foot Pegs', 'type' => 'motorcycle', 'price' => 45, 'stock' => 75],
            ['name' => 'Wheel Hub Assembly', 'type' => 'car', 'price' => 290, 'stock' => 22],
            ['name' => 'Rear Shock Linkage', 'type' => 'motorcycle', 'price' => 70, 'stock' => 50],
            ['name' => 'Oxygen Sensor', 'type' => 'car', 'price' => 120, 'stock' => 40],
            ['name' => 'Spark Plug Wires', 'type' => 'motorcycle', 'price' => 20, 'stock' => 100],
            ['name' => 'Exhaust Manifold', 'type' => 'car', 'price' => 300, 'stock' => 18],
            ['name' => 'CDI Unit', 'type' => 'motorcycle', 'price' => 55, 'stock' => 60],
            ['name' => 'Radiator Cap', 'type' => 'car', 'price' => 15, 'stock' => 100],
            ['name' => 'Crankshaft', 'type' => 'motorcycle', 'price' => 180, 'stock' => 25],
            ['name' => 'Parking Brake Cable', 'type' => 'car', 'price' => 75, 'stock' => 50],
            ['name' => 'Tire Tube', 'type' => 'motorcycle', 'price' => 25, 'stock' => 85],
            ['name' => 'Wheel Bearing', 'type' => 'car', 'price' => 110, 'stock' => 35],
            ['name' => 'Head Gasket', 'type' => 'motorcycle', 'price' => 40, 'stock' => 65],
            ['name' => 'Ignition Coil', 'type' => 'car', 'price' => 130, 'stock' => 25],
            ['name' => 'Fender', 'type' => 'motorcycle', 'price' => 35, 'stock' => 90],
            ['name' => 'Control Arm', 'type' => 'car', 'price' => 320, 'stock' => 20],
            ['name' => 'Engine Guard', 'type' => 'motorcycle', 'price' => 70, 'stock' => 50],
            ['name' => 'Transmission Mount', 'type' => 'car', 'price' => 230, 'stock' => 12],
            ['name' => 'Rear Brake Light', 'type' => 'motorcycle', 'price' => 20, 'stock' => 95],
            ['name' => 'Power Steering Pump', 'type' => 'car', 'price' => 200, 'stock' => 14],
            ['name' => 'Frame Sliders', 'type' => 'motorcycle', 'price' => 65, 'stock' => 55],
            ['name' => 'Catalytic Converter', 'type' => 'car', 'price' => 450, 'stock' => 10],
            ['name' => 'Engine Control Unit (ECU)', 'type' => 'motorcycle', 'price' => 180, 'stock' => 35],
            ['name' => 'Door Handle', 'type' => 'car', 'price' => 40, 'stock' => 70],
            ['name' => 'Radiator Hose', 'type' => 'motorcycle', 'price' => 25, 'stock' => 100],
            ['name' => 'Timing Chain', 'type' => 'car', 'price' => 180, 'stock' => 30],
            ['name' => 'Seat Cover', 'type' => 'motorcycle', 'price' => 50, 'stock' => 85],
            ['name' => 'Drive Shaft', 'type' => 'car', 'price' => 380, 'stock' => 10],
            ['name' => 'Throttle Body', 'type' => 'motorcycle', 'price' => 75, 'stock' => 40],
            ['name' => 'Transmission Fluid', 'type' => 'car', 'price' => 50, 'stock' => 65],
            ['name' => 'Foot Brake Pedal', 'type' => 'motorcycle', 'price' => 30, 'stock' => 75],
            ['name' => 'Engine Mount', 'type' => 'car', 'price' => 250, 'stock' => 12],
            ['name' => 'Front Fender', 'type' => 'motorcycle', 'price' => 35, 'stock' => 90],
            ['name' => 'Serpentine Belt', 'type' => 'car', 'price' => 100, 'stock' => 40],
            ['name' => 'Handlebar', 'type' => 'motorcycle', 'price' => 55, 'stock' => 65],
            ['name' => 'Alternator Belt', 'type' => 'car', 'price' => 85, 'stock' => 50],
            ['name' => 'Exhaust Valve', 'type' => 'motorcycle', 'price' => 60, 'stock' => 30],
            ['name' => 'Coolant Reservoir', 'type' => 'car', 'price' => 75, 'stock' => 45],
            ['name' => 'Clutch Cable', 'type' => 'motorcycle', 'price' => 25, 'stock' => 80],
            ['name' => 'A/C Compressor', 'type' => 'car', 'price' => 420, 'stock' => 12],
            ['name' => 'Tail Light Assembly', 'type' => 'motorcycle', 'price' => 40, 'stock' => 100],
            ['name' => 'Radiator Fan', 'type' => 'car', 'price' => 130, 'stock' => 25],
            ['name' => 'Battery Box', 'type' => 'motorcycle', 'price' => 35, 'stock' => 70],
            ['name' => 'Windshield Washer Pump', 'type' => 'car', 'price' => 50, 'stock' => 65],
            ['name' => 'Fuel Injector', 'type' => 'motorcycle', 'price' => 110, 'stock' => 45],
            ['name' => 'Door Lock Actuator', 'type' => 'car', 'price' => 90, 'stock' => 30],
            ['name' => 'Clutch Master Cylinder', 'type' => 'motorcycle', 'price' => 85, 'stock' => 60],
            ['name' => 'Fuel Pressure Regulator', 'type' => 'car', 'price' => 140, 'stock' => 25],
            ['name' => 'Air Intake Hose', 'type' => 'motorcycle', 'price' => 30, 'stock' => 85],
            ['name' => 'Steering Rack', 'type' => 'car', 'price' => 320, 'stock' => 15],
            ['name' => 'Swingarm', 'type' => 'motorcycle', 'price' => 120, 'stock' => 35],
            ['name' => 'Fog Light', 'type' => 'car', 'price' => 75, 'stock' => 50],
            ['name' => 'Throttle Position Sensor', 'type' => 'motorcycle', 'price' => 45, 'stock' => 40],
            ['name' => 'Oil Cooler', 'type' => 'car', 'price' => 110, 'stock' => 35],
            ['name' => 'Brake Lever', 'type' => 'motorcycle', 'price' => 25, 'stock' => 90],
            ['name' => 'Fuel Tank Cap', 'type' => 'car', 'price' => 15, 'stock' => 100],
            ['name' => 'Brake Rotor', 'type' => 'motorcycle', 'price' => 95, 'stock' => 45],
            ['name' => 'Hood Latch', 'type' => 'car', 'price' => 45, 'stock' => 65],
            ['name' => 'Wheel Spacer', 'type' => 'motorcycle', 'price' => 30, 'stock' => 80],
            ['name' => 'Exhaust Header', 'type' => 'car', 'price' => 380, 'stock' => 18],
            ['name' => 'Instrument Cluster', 'type' => 'motorcycle', 'price' => 150, 'stock' => 25],
            ['name' => 'Door Seal', 'type' => 'car', 'price' => 40, 'stock' => 75],
            ['name' => 'Front Fork', 'type' => 'motorcycle', 'price' => 100, 'stock' => 30],
            ['name' => 'Window Regulator', 'type' => 'car', 'price' => 90, 'stock' => 40],
            ['name' => 'Kickstart Lever', 'type' => 'motorcycle', 'price' => 20, 'stock' => 95],
            ['name' => 'Grille', 'type' => 'car', 'price' => 160, 'stock' => 20],
            ['name' => 'Brake Master Cylinder', 'type' => 'motorcycle', 'price' => 65, 'stock' => 50],
            ['name' => 'Trunk Lid', 'type' => 'car', 'price' => 300, 'stock' => 12],
            ['name' => 'License Plate Holder', 'type' => 'motorcycle', 'price' => 20, 'stock' => 100],
            ['name' => 'Side Mirror', 'type' => 'car', 'price' => 85, 'stock' => 30],
            ['name' => 'Gear Shift Linkage', 'type' => 'motorcycle', 'price' => 45, 'stock' => 85],
        ];

        foreach ($spareparts as $index => &$sparepart) {
            $sparepart['price'] = $sparepart['price'] * 1000; // Multiply price by 1,000
            $sparepart['id'] = sprintf('SPRPT-%03d', $index + 1); // Add ID format
        }

        DB::table('spareparts')->insert($spareparts);
    }
}

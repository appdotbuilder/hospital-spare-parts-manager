<?php

namespace Database\Seeders;

use App\Models\SparePart;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SparePartSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $suppliers = Supplier::all();
        
        $spareParts = [
            [
                'name' => 'HVAC Filter - HEPA Grade',
                'code' => 'HVAC-001',
                'quantity' => 25,
                'storage_location' => 'A1-B2',
                'price' => 45.99,
                'minimum_stock' => 10,
                'description' => 'High-efficiency particulate air filter for hospital HVAC systems',
                'status' => 'active',
            ],
            [
                'name' => 'Emergency Generator Belt',
                'code' => 'GEN-002',
                'quantity' => 8,
                'storage_location' => 'C3-D4',
                'price' => 125.50,
                'minimum_stock' => 5,
                'description' => 'Drive belt for emergency backup generators',
                'status' => 'active',
            ],
            [
                'name' => 'Water Pump Seal Kit',
                'code' => 'WP-003',
                'quantity' => 3,
                'storage_location' => 'E5-F6',
                'price' => 89.75,
                'minimum_stock' => 5,
                'description' => 'Complete seal kit for hospital water pumps',
                'status' => 'active',
            ],
            [
                'name' => 'LED Light Panel - OR',
                'code' => 'LED-004',
                'quantity' => 15,
                'storage_location' => 'G7-H8',
                'price' => 275.00,
                'minimum_stock' => 8,
                'description' => 'Operating room LED light panel replacement',
                'status' => 'active',
            ],
            [
                'name' => 'Pressure Relief Valve',
                'code' => 'PRV-005',
                'quantity' => 12,
                'storage_location' => 'I9-J10',
                'price' => 165.25,
                'minimum_stock' => 6,
                'description' => 'Safety pressure relief valve for steam systems',
                'status' => 'active',
            ],
            [
                'name' => 'Motor Controller Board',
                'code' => 'MCB-006',
                'quantity' => 4,
                'storage_location' => 'K11-L12',
                'price' => 425.00,
                'minimum_stock' => 3,
                'description' => 'Electronic motor controller for elevator systems',
                'status' => 'active',
            ],
            [
                'name' => 'Thermostat - Digital',
                'code' => 'THERM-007',
                'quantity' => 18,
                'storage_location' => 'M13-N14',
                'price' => 95.50,
                'minimum_stock' => 10,
                'description' => 'Digital thermostat for room temperature control',
                'status' => 'active',
            ],
            [
                'name' => 'Isolation Transformer',
                'code' => 'ISO-008',
                'quantity' => 2,
                'storage_location' => 'O15-P16',
                'price' => 1250.00,
                'minimum_stock' => 2,
                'description' => 'Medical grade isolation transformer',
                'status' => 'active',
            ],
            [
                'name' => 'Fire Damper Actuator',
                'code' => 'FDA-009',
                'quantity' => 6,
                'storage_location' => 'Q17-R18',
                'price' => 185.75,
                'minimum_stock' => 4,
                'description' => 'Actuator for automatic fire dampers',
                'status' => 'active',
            ],
            [
                'name' => 'Battery - UPS System',
                'code' => 'UPS-010',
                'quantity' => 1,
                'storage_location' => 'S19-T20',
                'price' => 850.00,
                'minimum_stock' => 3,
                'description' => 'Replacement battery for uninterruptible power supply',
                'status' => 'active',
            ],
        ];

        foreach ($spareParts as $index => $part) {
            // Assign supplier randomly
            $part['supplier_id'] = $suppliers->random()->id;
            
            SparePart::firstOrCreate(['code' => $part['code']], $part);
        }
    }
}
<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $suppliers = [
            [
                'name' => 'MedTech Solutions',
                'code' => 'MTS001',
                'address' => '123 Medical District, Healthcare City, HC 12345',
                'phone' => '+1-555-0123',
                'email' => 'orders@medtechsolutions.com',
                'contact_person' => 'John Smith',
                'status' => 'active',
            ],
            [
                'name' => 'Hospital Equipment Co.',
                'code' => 'HEC002',
                'address' => '456 Industrial Ave, Equipment Town, ET 67890',
                'phone' => '+1-555-0456',
                'email' => 'sales@hospitalequipment.com',
                'contact_person' => 'Sarah Johnson',
                'status' => 'active',
            ],
            [
                'name' => 'Engineering Parts Direct',
                'code' => 'EPD003',
                'address' => '789 Parts Plaza, Supply City, SC 13579',
                'phone' => '+1-555-0789',
                'email' => 'info@engpartsdirect.com',
                'contact_person' => 'Mike Wilson',
                'status' => 'active',
            ],
            [
                'name' => 'Precision Medical Components',
                'code' => 'PMC004',
                'address' => '321 Component Street, Parts Valley, PV 24680',
                'phone' => '+1-555-0321',
                'email' => 'support@precisionmedical.com',
                'contact_person' => 'Lisa Chen',
                'status' => 'active',
            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::firstOrCreate(['code' => $supplier['code']], $supplier);
        }
    }
}
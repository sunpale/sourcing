<?php

namespace Database\Seeders;

use App\Models\master_data\Brand;
use Illuminate\Database\Seeder;

class BrandsSeeder extends Seeder
{
    public function run(): void
    {
        Brand::insert([
            'kode' => '00',
            'brand' => 'All Brand',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}

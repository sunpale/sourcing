<?php

namespace Database\Seeders;

use App\Models\master_material\ProductGroup;
use Illuminate\Database\Seeder;

class ProductGroupSeeder extends Seeder
{
    public function run(): void
    {
        ProductGroup::insert([
            'kode'          => 'BD',
            'type'          => 'Raw Material',
            'group'         => 'Body',
            'created_by'    => 1,
            'updated_by'    => 1,
            'created_at'    => now(),
            'updated_at'    => now()],
        );

        ProductGroup::insert([
            'kode'          => 'RB',
            'type'          => 'Raw Material',
            'group'         => 'Rib',
            'created_by'    => 1,
            'updated_by'    => 1,
            'created_at'    => now(),
            'updated_at'    => now()],
        );
    }
}

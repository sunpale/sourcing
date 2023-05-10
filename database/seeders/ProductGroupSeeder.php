<?php

namespace Database\Seeders;

use App\Models\master_aks\ProductGroup;
use Illuminate\Database\Seeder;

class ProductGroupSeeder extends Seeder
{
    public function run(): void
    {
        ProductGroup::insert([
            'kode'          => 'NG',
            'group'         => 'Non Group',
            'created_by'    => 1,
            'updated_by'    => 1,
            'created_at'    => now(),
            'updated_at'    => now()],
        );
        ProductGroup::insert([
            'kode'          => 'BD',
            'group'         => 'Body',
            'created_by'    => 1,
            'updated_by'    => 1,
            'created_at'    => now(),
            'updated_at'    => now()],
        );

        ProductGroup::insert([
            'kode'          => 'RB',
            'group'         => 'Rib',
            'created_by'    => 1,
            'updated_by'    => 1,
            'created_at'    => now(),
            'updated_at'    => now()],
        );
    }
}

<?php

namespace Database\Seeders;

use App\Models\master_data\Size;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class ArticleSizeSeeder extends Seeder
{
    public function run(): void
    {
        Size::insert([
            'id'        => 1,
            'size'      => 'All Size',
            'remarks'   => 'General Size for All Article',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now()]);
    }
}

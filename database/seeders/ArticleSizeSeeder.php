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
            'size'      => 'All Size',
            'remarks'   => 'General Size for All Article',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now()]
        );
        Size::insert([
            'size'      => 'S',
            'remarks'   => '',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now()]
        );
        Size::insert([
            'size'      => 'M',
            'remarks'   => '',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now()]
        );
        Size::insert([
            'size'      => 'L',
            'remarks'   => '',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now()]
        );
        Size::insert([
            'size'      => 'XL',
            'remarks'   => '',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now()]
        );
    }
}

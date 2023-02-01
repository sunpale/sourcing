<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $user = User::create([
            'name' => 'Super Administrator',
            'username' => 'administrator',
            'password' => Hash::make('Akira66217',['memory'=>1024,'time'=>2,'threads'=>2]),
        ]);

        $user->assignRole('administrator');
    }
}

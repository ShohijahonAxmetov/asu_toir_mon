<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(!User::find(1)) User::create([
            'id' => 1,
            'name' => 'Admin',
            'email' => 'admin',
            'password' => Hash::make(123123)
        ]);
    }
}

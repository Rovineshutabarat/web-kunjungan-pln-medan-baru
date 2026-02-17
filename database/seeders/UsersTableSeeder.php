<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'username' => 'admin',
                'nama' => 'Administrator',
                'password' => 'admin123', // Password plain text
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'petugas',
                'nama' => 'Petugas 1',
                'password' => 'petugas123',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
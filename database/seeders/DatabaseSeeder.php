<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'nama' => 'Admin Sekretariat',
            'username' => 'adminsekret',
            'password' => bcrypt('password'),
            'role' => 'ADMINSEKRET',
        ]);

        \App\Models\User::create([
            'nama' => 'Admin Divisi',
            'username' => 'admindivisi',
            'password' => bcrypt('password'),
            'role' => 'ADMINDIVISI',
        ]);
    }
}

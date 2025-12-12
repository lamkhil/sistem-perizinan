<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Seeder dikosongkan - semua data akan diisi manual oleh user melalui aplikasi.
     */
    public function run(): void
    {
        $this->command->info('ℹ️  UserSeeder dikosongkan. Data user akan diisi manual melalui aplikasi.');
    }
}

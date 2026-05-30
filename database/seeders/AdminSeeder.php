<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->updateOrInsert(
            ['email' => 'admin@sautigang.studio'],
            [
                'name'              => 'Studio Admin',
                'email'             => 'admin@sautigang.studio',
                'password'          => Hash::make('SautiGang@2025'),
                'email_verified_at' => now(),
                'created_at'        => now(),
                'updated_at'        => now(),
            ]
        );
    }
}
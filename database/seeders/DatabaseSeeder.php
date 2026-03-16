<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
//         \App\Models\User::factory(10)->create();

         User::factory()->create([
             'name' => 'Test Admin',
             'email' => 'pedro.araujo@merlion-si.com.br',
             'password' => Hash::make('123456'),
             'email_verified_at' => Carbon::now(),
             'is_admin' => true,
         ]);

        User::factory()->create([
            'name' => 'Test User 1',
            'email' => 'pedro.araujo1@merlion-si.com.br',
            'password' => Hash::make('123456'),
            'email_verified_at' => Carbon::now(),
            'is_admin' => false,
        ]);

        User::factory()->create([
            'name' => 'Test User 2',
            'email' => 'pedro.araujo2@merlion-si.com.br',
            'password' => Hash::make('123456'),
            'email_verified_at' => Carbon::now(),
            'is_admin' => false,
        ]);

        User::factory()->create([
            'name' => 'Test User 3',
            'email' => 'pedro.araujo3@merlion-si.com.br',
            'password' => Hash::make('123456'),
            'email_verified_at' => Carbon::now(),
            'is_admin' => false,
        ]);
    }
}

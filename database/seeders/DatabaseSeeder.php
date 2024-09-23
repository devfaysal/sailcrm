<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Admin::create([
            'name' => 'Faysal Ahamed',
            'email' => 'faysal@surovigroup.net',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);
        User::create([
            'name' => 'Territory Officer',
            'email' => 'officer@surovigroup.net',
            'phone_number' => '01670347708',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);
        $this->call([
            \Devfaysal\BangladeshGeocode\Seeders\DivisionSeeder::class,
            \Devfaysal\BangladeshGeocode\Seeders\DistrictSeeder::class,
            \Devfaysal\BangladeshGeocode\Seeders\UpazilaSeeder::class,
            \Devfaysal\BangladeshGeocode\Seeders\UnionSeeder::class,
        ]);
    }
}

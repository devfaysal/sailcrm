<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Crop;
use App\Models\Territory;
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
        $this->call([
            \Devfaysal\BangladeshGeocode\Seeders\DivisionSeeder::class,
            \Devfaysal\BangladeshGeocode\Seeders\DistrictSeeder::class,
            \Devfaysal\BangladeshGeocode\Seeders\UpazilaSeeder::class,
            \Devfaysal\BangladeshGeocode\Seeders\UnionSeeder::class,
        ]);
        Crop::insert([
            ['name' => 'Rice'],
            ['name' => 'Potato'],
            ['name' => 'Tomato'],
        ]);
        Admin::create([
            'name' => 'Faysal Ahamed',
            'email' => 'faysal@surovigroup.net',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);
        $officer = User::create([
            'name' => 'John Doe',
            'email' => 'officer@surovigroup.net',
            'phone_number' => '01670347708',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);

        Territory::create([
            'name' => 'Kishoreganj',
            'user_id' => $officer->id,
            'division_id' => 6, //Dhaka
            'district_id' => 45, //Kishoreganj
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Territory;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $feed = database_path('data/officers.csv');
        $officers = array_map('str_getcsv', file($feed));

        foreach($officers as $key => $officer){
            $user = User::create([
                'name' => $officer[0],
                'email' => 'officer'. ($key+1) .'@surovigroup.net',
                'phone_number' => substr($officer[2], 2),
                'email_verified_at' => now(),
                'password' => Hash::make('$urovigroup'),
                'remember_token' => Str::random(10),
            ]);

            Territory::create([
                'name' => $officer[1],
                'user_id' => $user->id,
            ]);
        }
    }
}

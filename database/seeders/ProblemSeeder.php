<?php

namespace Database\Seeders;

use App\Models\Problem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProblemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $problems = [
            'আঙ্গুলি ঘাস',
            'উলু ঘাস',
            'এড়াইল',
            'কাঁটানটে',
            'কানাইবাশি',
            'ক্ষুদে শ্যামা',
            'চাপড়া',
        ];
        foreach ($problems as $problem) {
            Problem::create([
                'name' => $problem,
            ]);
        }
    }
}

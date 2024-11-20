<?php

namespace Database\Seeders;

use App\Models\Crop;
use Illuminate\Database\Seeder;

class CropSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Crop::truncate();
        
        $crops = [
            'ধান',
            'আলু',
            'গম',
            'পাট',
            'ভুট্টা',
            'সয়াবিন',
            'মসুর',
            'মুগ',
            'ছোলা',
            'মাসকালাই',
            'সরিষা',
            'বেগুন',
            'টমেটো',
            'ফুল কপি',
            'বাধা কপি',
            'করলা',
            'লাউ',
            'মিস্টি কুমড়া',
            'চাল কুমড়া',
            'ঝিঙ্গা',
            'চিচিঙ্গা',
            'ধুন্দল',
            'শসা',
            'শিম',
            'বরবটী',
            'ঢেঁরশ',
            'শাক',
            'পটল',
            'আম',
            'কাঠাল',
            'কলা',
            'লিচু',
            'পেপে',
            'কমলা লেবু',
            'মাল্টা',
            'বড়ই',
            'স্ট্রবেরি',
            'পেঁয়াজ',
            'মরিচ',
            'রসুন',
            'চিনাবাদাম',
            'আখ',
            'তুলা',
            'পান',
            'লাউ',
            'ধনিয়া',
        ];
        
        $cropsData = [];
        foreach($crops as $crop){
            $cropsData[] = ['name' => $crop];
        }
        Crop::insert($cropsData);
    }
}

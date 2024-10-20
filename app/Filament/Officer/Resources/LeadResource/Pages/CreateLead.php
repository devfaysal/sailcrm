<?php

namespace App\Filament\Officer\Resources\LeadResource\Pages;

use App\Filament\Officer\Resources\LeadResource;
use App\Models\Lead;
use App\Models\Visit;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateLead extends CreateRecord
{
    protected static string $resource = LeadResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        // dd($data);
        $territory = auth()->user()->territory;
        $lead = Lead::create([
            'territory_id' => $territory->id,
            'type' => $data['type'],
            'name' => $data['name'],
            'shop_name' => $data['shop_name'],
            'phone_number' => $data['phone_number'],
            'division_id' => $territory->division_id,
            'district_id' => $territory->district_id,
            'upazila_id' => $data['upazila_id'],
            'union_id' => $data['union_id'],
            'address' => $data['address'],
            'post_code' => $data['address'],
        ]);

        if(count($data['Solutions'])){
            foreach ($data['Solutions'] as $solution) {
                Visit::create([
                    'lead_id' => $lead->id,
                    'crop_id' => $solution['crop_id'],
                    'problem' => $solution['problem'],
                    'solution' => $solution['solution'],
                    'visited_at' => $solution['visited_at'],
                ]);
            }
        }
        
        return $lead;
    }
}

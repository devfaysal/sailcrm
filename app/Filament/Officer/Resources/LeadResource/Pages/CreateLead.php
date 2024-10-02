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

        Visit::create([
            'lead_id' => $lead->id,
            'crop_id' => $data['crop_id'],
            'problem' => $data['problem'],
            'solution' => $data['solution'],
            'visited_at' => $data['visited_at'],
        ]);

        return $lead;
    }
}

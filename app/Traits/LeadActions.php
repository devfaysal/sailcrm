<?php
namespace App\Traits;

use App\Models\Lead;
use App\Models\Territory;
use App\Models\Visit;

trait LeadActions
{
    public function createLeadAction(array $data)
    {
        if(isset($data['territory_id'])){
            $territory = Territory::find($data['territory_id']);
        }else{
            $territory = auth()->user()->territory;
        }
        
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
            'post_code' => $data['post_code'],
        ]);

        if (count($data['solutions'])) {
            foreach ($data['solutions'] as $solution) {
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
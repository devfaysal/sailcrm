<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Visit;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function store(Request $request)
    {
        $territory = $request->user()->territory;
        $data = $request->validate([
            'type' => 'required',
            'name' => 'required',
            'shop_name' => 'nullable',
            'phone_number' => 'required',
            'upazila_id' => 'required',
            'union_id' => 'required',
            'address' => 'required',
            'post_code' => 'nullable',
            'picture' => 'nullable',
            'solutions' => ['required', 'array']
        ]);

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

        if(isset($data['picture'])){
            $lead->attachPicture($data['picture']);
        }

        if (count($data['solutions'])) {
            foreach ($data['solutions'] as $solution) {
                Visit::create([
                    'lead_id' => $lead->id,
                    'crop_id' => $solution['crop_id'],
                    'problem' => $solution['problem'],
                    'solution' => $solution['solution'],
                    'visited_at' => $solution['visited_at'],
                    'lat' => $solution['lat'],
                    'lon' => $solution['lon'],
                ]);
            }
        }

        return response()->json($lead->fresh());
    }
}

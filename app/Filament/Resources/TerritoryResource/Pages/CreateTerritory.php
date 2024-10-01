<?php

namespace App\Filament\Resources\TerritoryResource\Pages;

use App\Filament\Resources\TerritoryResource;
use Devfaysal\BangladeshGeocode\Models\District;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTerritory extends CreateRecord
{
    protected static string $resource = TerritoryResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $district = District::find($data['district_id']);
        $data['division_id'] = $district->division->id;
        return $data;
    }
}

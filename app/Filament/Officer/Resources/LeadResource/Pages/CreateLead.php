<?php

namespace App\Filament\Officer\Resources\LeadResource\Pages;

use App\Filament\Officer\Resources\LeadResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLead extends CreateRecord
{
    protected static string $resource = LeadResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['territory_id'] = auth()->user()->territory->id;
        return $data;
    }
}

<?php

namespace App\Filament\Officer\Resources\LeadResource\Pages;

use App\Filament\Officer\Resources\LeadResource;
use App\Models\Lead;
use App\Models\Visit;
use App\Traits\LeadActions;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateLead extends CreateRecord
{
    use LeadActions;
    
    protected static string $resource = LeadResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        return $this->createLeadAction($data);
    }
}

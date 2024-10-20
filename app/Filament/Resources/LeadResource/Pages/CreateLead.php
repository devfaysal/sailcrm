<?php

namespace App\Filament\Resources\LeadResource\Pages;

use App\Filament\Resources\LeadResource;
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

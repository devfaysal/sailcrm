<?php

namespace App\Filament\Officer\Resources\LeadResource\Pages;

use App\Filament\Officer\Resources\LeadResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLead extends CreateRecord
{
    protected static string $resource = LeadResource::class;
}

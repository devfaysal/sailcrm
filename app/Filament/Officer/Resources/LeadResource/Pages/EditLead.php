<?php

namespace App\Filament\Officer\Resources\LeadResource\Pages;

use App\Filament\Officer\Resources\LeadResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditLead extends EditRecord
{
    protected static string $resource = LeadResource::class;

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->update([
            'type' => $data['type'],
            'name' => $data['name'],
            'shop_name' => $data['shop_name'],
            'phone_number' => $data['phone_number'],
            'upazila_id' => $data['upazila_id'],
            'union_id' => $data['union_id'],
            'address' => $data['address'],
            'post_code' => $data['address'],
        ]);
        return $record;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

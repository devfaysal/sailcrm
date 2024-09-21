<?php

namespace App\Filament\Officer\Pages;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Auth\Login as BasePage;
use Illuminate\Validation\ValidationException;

class OfficerLogin extends BasePage
{
    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'phone_number' => $data['phone_number'],
            'password' => $data['password'],
        ];
    }

    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('phone_number')
        ->label('Phone Number')
        ->required()
            ->autocomplete()
            ->autofocus()
            ->extraInputAttributes(['tabindex' => 1]);
    }

    protected function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.phone' => __('filament-panels::pages/auth/login.messages.failed'),
        ]);
    }
}

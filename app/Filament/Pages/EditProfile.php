<?php

namespace App\Filament\Pages;

use Filament\Pages\Auth\EditProfile as Base;

class EditProfile extends Base
{
    protected function fillForm(): void
    {
        $data = $this->getUser()->attributesToArray();

        $this->callHook('beforeFill');

        $data = $this->mutateFormDataBeforeFill($data);
        unset($data['password']);
        $this->form->fill($data);

        $this->callHook('afterFill');
    }

    protected function getRedirectUrl(): ?string
    {
        return '/admin';
    }
}

<?php

namespace App\Filament\Customer\Pages\Auth;

use Filament\Auth\Pages\Register as BaseRegister;
use Filament\Forms\Components\Checkbox;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;

class Register extends BaseRegister
{
    public function getHeading(): string
    {
        return 'Create your VortexCloud Account';
    }

    public function getSubheading(): ?string
    {
        return 'Deploy high-performance NVMe cloud VPS instances in seconds.';
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getNameFormComponent(),
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
                Checkbox::make('terms')
                    ->label(new HtmlString('I have read and agree to the <a href="/terms-of-service" target="_blank" class="text-[#673DE6] underline font-semibold">Terms of Service</a> and <a href="/privacy-policy" target="_blank" class="text-[#673DE6] underline font-semibold">Privacy Policy</a>.'))
                    ->accepted()
                    ->required()
                    ->dehydrated(false)
                    ->validationMessages([
                        'accepted' => 'You must agree to the Terms of Service and Privacy Policy to register.',
                        'required' => 'You must agree to the Terms of Service and Privacy Policy to register.',
                    ]),
            ]);
    }
}

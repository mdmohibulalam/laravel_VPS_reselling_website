<?php

namespace App\Filament\Customer\Pages\Auth;

use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class Login extends BaseLogin
{
    public function getHeading(): string
    {
        return 'Sign in to VortexCloud';
    }

    public function getSubheading(): ?string
    {
        return 'Access your customer portal, active VPS instances, and invoices.';
    }

    public function quickDemoLogin()
    {
        if (!config('app.demo_login_enabled')) {
            return;
        }

        $user = User::where('email', 'test@example.com')->first();
        if (!$user) {
            $user = User::create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => Hash::make('password'),
            ]);
        }

        Auth::guard('web')->login($user, true);

        return redirect()->intended(Filament::getUrl());
    }
}

<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class Login extends BaseLogin
{
    public function getHeading(): string
    {
        return 'VortexCloud Admin Console';
    }

    public function getSubheading(): ?string
    {
        return 'Infrastructure Control & Server Provisioning Management';
    }

    public function quickDemoLogin()
    {
        if (!config('app.demo_login_enabled')) {
            return;
        }

        $admin = Admin::where('email', 'admin@example.com')->first();
        if (!$admin) {
            $admin = Admin::create([
                'name' => 'Super Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
            ]);
            $admin->assignRole('super_admin');
        }

        Auth::guard('admin')->login($admin, true);

        return redirect()->intended(Filament::getUrl());
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Provisioning\ProvisioningServiceInterface;
use App\Services\Provisioning\ContaboProvisioningService;
use App\Services\Provisioning\MockProvisioningService;

class ProvisioningServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ProvisioningServiceInterface::class, function ($app) {
            if (config('services.provisioning.mode') === 'live') {
                return new ContaboProvisioningService();
            }
            
            return new MockProvisioningService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

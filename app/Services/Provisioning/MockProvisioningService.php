<?php

namespace App\Services\Provisioning;

use Illuminate\Support\Str;

class MockProvisioningService implements ProvisioningServiceInterface
{
    public function createInstance(array $orderData): ProvisioningResult
    {
        $instanceId = 'mock_contabo_' . Str::random(10);
        $ipAddress = mt_rand(1, 255) . '.' . mt_rand(0, 255) . '.' . mt_rand(0, 255) . '.' . mt_rand(1, 254);

        return ProvisioningResult::success([
            'instanceId' => $instanceId,
            'ipAddress' => $ipAddress,
            'initialPassword' => Str::random(12),
        ], 'Mock instance created successfully.');
    }

    public function startInstance(string $instanceId): ProvisioningResult
    {
        return ProvisioningResult::success([], 'Mock instance started.');
    }

    public function stopInstance(string $instanceId): ProvisioningResult
    {
        return ProvisioningResult::success([], 'Mock instance stopped.');
    }

    public function rebootInstance(string $instanceId): ProvisioningResult
    {
        return ProvisioningResult::success([], 'Mock instance rebooted.');
    }

    public function getInstanceStatus(string $instanceId): ProvisioningResult
    {
        return ProvisioningResult::success([
            'status' => 'running',
        ], 'Mock instance status retrieved.');
    }

    public function reinstallInstance(string $instanceId, array $options): ProvisioningResult
    {
        return ProvisioningResult::success([
            'initialPassword' => Str::random(12),
        ], 'Mock instance reinstalled.');
    }
}

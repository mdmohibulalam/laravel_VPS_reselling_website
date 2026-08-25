<?php

namespace App\Services\Provisioning;

interface ProvisioningServiceInterface
{
    public function createInstance(array $orderData): ProvisioningResult;
    public function startInstance(string $instanceId): ProvisioningResult;
    public function stopInstance(string $instanceId): ProvisioningResult;
    public function rebootInstance(string $instanceId): ProvisioningResult;
    public function getInstanceStatus(string $instanceId): ProvisioningResult;
    public function reinstallInstance(string $instanceId, array $options): ProvisioningResult;
}

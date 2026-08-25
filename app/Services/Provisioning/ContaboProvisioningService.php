<?php

namespace App\Services\Provisioning;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Models\ProvisioningLog;

class ContaboProvisioningService implements ProvisioningServiceInterface
{
    protected string $baseUrl;
    protected string $clientId;
    protected string $clientSecret;
    protected string $apiUser;
    protected string $apiPassword;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.contabo.base_url', 'https://api.contabo.com'), '/');
        $this->clientId = config('services.contabo.client_id');
        $this->clientSecret = config('services.contabo.client_secret');
        $this->apiUser = config('services.contabo.api_user');
        $this->apiPassword = config('services.contabo.api_password');
    }

    protected function getAccessToken(): string
    {
        return Cache::remember('contabo_access_token', 280, function () {
            $response = Http::asForm()->post($this->baseUrl . '/oauth2/token', [
                'grant_type' => 'password',
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'username' => $this->apiUser,
                'password' => $this->apiPassword,
            ]);

            if ($response->failed()) {
                throw new \Exception('Failed to authenticate with Contabo API: ' . $response->body());
            }

            return $response->json('access_token');
        });
    }

    protected function request(string $method, string $endpoint, array $data = [], ?int $serviceId = null, string $action = '')
    {
        $token = $this->getAccessToken();
        
        $url = $this->baseUrl . '/v1/' . ltrim($endpoint, '/');
        
        $response = Http::withToken($token)
            ->acceptJson()
            ->withHeaders([
                'x-request-id' => (string) \Illuminate\Support\Str::uuid(),
            ])
            ->$method($url, $data);
            
        // Log the request
        $this->logProvisioning($serviceId, $action, $data, $response->json(), $response->successful());

        return $response;
    }

    protected function logProvisioning(?int $serviceId, string $action, array $request, ?array $response, bool $isSuccess)
    {
        // Sanitize credentials from request payload before logging
        if (isset($request['password'])) {
            $request['password'] = '***';
        }
        
        ProvisioningLog::create([
            'service_id' => $serviceId,
            'action' => $action,
            'request_payload' => $request,
            'response_payload' => $response,
            'is_success' => $isSuccess,
        ]);
    }

    public function createInstance(array $orderData): ProvisioningResult
    {
        try {
            $response = $this->request('post', 'compute/instances', $orderData['api_payload'], $orderData['service_id'] ?? null, 'create_instance');

            if ($response->successful()) {
                $data = $response->json('data')[0] ?? [];
                return ProvisioningResult::success([
                    'instanceId' => $data['instanceId'] ?? '',
                    'ipAddress' => $data['ipConfig']['v4']['ip'] ?? '',
                ], 'Instance created successfully.', $response->json());
            }

            return ProvisioningResult::failure('Failed to create instance.', $response->json());
        } catch (\Exception $e) {
            return ProvisioningResult::failure($e->getMessage());
        }
    }

    public function startInstance(string $instanceId): ProvisioningResult
    {
        try {
            $response = $this->request('post', "compute/instances/{$instanceId}/actions/start", [], null, 'start_instance');
            
            if ($response->successful()) {
                return ProvisioningResult::success([], 'Instance started.', $response->json());
            }

            return ProvisioningResult::failure('Failed to start instance.', $response->json());
        } catch (\Exception $e) {
            return ProvisioningResult::failure($e->getMessage());
        }
    }

    public function stopInstance(string $instanceId): ProvisioningResult
    {
        try {
            $response = $this->request('post', "compute/instances/{$instanceId}/actions/stop", [], null, 'stop_instance');
            
            if ($response->successful()) {
                return ProvisioningResult::success([], 'Instance stopped.', $response->json());
            }

            return ProvisioningResult::failure('Failed to stop instance.', $response->json());
        } catch (\Exception $e) {
            return ProvisioningResult::failure($e->getMessage());
        }
    }

    public function rebootInstance(string $instanceId): ProvisioningResult
    {
        try {
            $response = $this->request('post', "compute/instances/{$instanceId}/actions/restart", [], null, 'reboot_instance');
            
            if ($response->successful()) {
                return ProvisioningResult::success([], 'Instance rebooted.', $response->json());
            }

            return ProvisioningResult::failure('Failed to reboot instance.', $response->json());
        } catch (\Exception $e) {
            return ProvisioningResult::failure($e->getMessage());
        }
    }

    public function getInstanceStatus(string $instanceId): ProvisioningResult
    {
        try {
            $response = $this->request('get', "compute/instances/{$instanceId}", [], null, 'get_status');
            
            if ($response->successful()) {
                $data = $response->json('data')[0] ?? [];
                return ProvisioningResult::success([
                    'status' => $data['status'] ?? 'unknown',
                ], 'Instance status retrieved.', $response->json());
            }

            return ProvisioningResult::failure('Failed to retrieve status.', $response->json());
        } catch (\Exception $e) {
            return ProvisioningResult::failure($e->getMessage());
        }
    }

    public function reinstallInstance(string $instanceId, array $options): ProvisioningResult
    {
        try {
            $response = $this->request('post', "compute/instances/{$instanceId}/actions/reinstall", $options, null, 'reinstall_instance');
            
            if ($response->successful()) {
                return ProvisioningResult::success([], 'Instance reinstalled.', $response->json());
            }

            return ProvisioningResult::failure('Failed to reinstall instance.', $response->json());
        } catch (\Exception $e) {
            return ProvisioningResult::failure($e->getMessage());
        }
    }
}

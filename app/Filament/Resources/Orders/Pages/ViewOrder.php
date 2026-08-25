<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use App\Models\Service;
use App\Services\Provisioning\ProvisioningServiceInterface;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Str;
use App\Mail\ServiceDeliveredMail;
use Illuminate\Support\Facades\Mail;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [


            Action::make('provision_contabo')
                ->label('Go to Contabo')
                ->icon('heroicon-o-cloud-arrow-up')
                ->color('warning')
                ->modalHeading('Provision VPS via Contabo API')
                ->modalDescription('Configure server parameters and submit to Contabo API to provision the server instance.')
                ->modalSubmitActionLabel('Provision on Contabo')
                ->visible(fn () => in_array($this->record->status, ['pending', 'provision', 'failed']))
                ->form(function () {
                    $service = $this->record->services()->first();
                    $package = $service?->package;
                    $defaultProductId = $package?->contabo_product_id ?? 'V153';

                    return [
                        TextInput::make('product_id')
                            ->label('Contabo Product ID')
                            ->default($defaultProductId)
                            ->required(),
                        Select::make('region')
                            ->label('Datacenter Region')
                            ->options([
                                'EU' => 'European Union (Germany)',
                                'US-central' => 'United States (Central)',
                                'US-east' => 'United States (East)',
                                'US-west' => 'United States (West)',
                                'SIN' => 'Singapore (Asia)',
                                'UK' => 'United Kingdom',
                                'AUS' => 'Australia',
                            ])
                            ->default(config('services.contabo.default_region', 'EU'))
                            ->required(),
                        Select::make('image_id')
                            ->label('Operating System Image')
                            ->options([
                                'afecbb85-e2fc-46f0-9684-b46b1faf00bb' => 'Ubuntu 22.04 LTS',
                                '9b1deb4d-3b7d-4bad-9bdd-2b0d7b3dcb6d' => 'Ubuntu 20.04 LTS',
                                'a2c26e8f-84a5-4f3e-9c0e-b06511928cc0' => 'Debian 12',
                                'c3d4e5f6-7a8b-9c0d-1e2f-3a4b5c6d7e8f' => 'Windows Server 2022',
                            ])
                            ->default('afecbb85-e2fc-46f0-9684-b46b1faf00bb')
                            ->required(),
                        TextInput::make('default_user')
                            ->label('Default User')
                            ->default('root')
                            ->required(),
                        TextInput::make('root_password')
                            ->label('Root Password')
                            ->default(fn () => Str::password(16, true, true, false, false) . 'A1!')
                            ->required(),
                        TextInput::make('display_name')
                            ->label('Server Display Name')
                            ->default('VPS-' . $this->record->order_number),
                    ];
                })
                ->action(function (array $data, ProvisioningServiceInterface $provisioningService) {
                    $services = $this->record->services;
                    if ($services->isEmpty()) {
                        $service = Service::create([
                            'user_id' => $this->record->user_id,
                            'order_id' => $this->record->id,
                            'package_id' => \App\Models\Package::first()?->id ?? 1,
                            'status' => 'provisioning',
                            'billing_cycle' => 'monthly',
                        ]);
                        $services = collect([$service]);
                    }

                    $successCount = 0;
                    $lastError = '';

                    foreach ($services as $service) {
                        $orderPayload = array_merge($data, ['service_id' => $service->id, 'period' => 1]);
                        $result = $provisioningService->createInstance($orderPayload);

                        if ($result->success) {
                            $service->update([
                                'contabo_instance_id' => $result->data['instanceId'] ?? '',
                                'ip_address' => $result->data['ipAddress'] ?? 'Pending IP',
                                'encrypted_credentials' => encrypt($result->data['initialPassword'] ?? $data['root_password']),
                                'default_user' => $result->data['defaultUser'] ?? $data['default_user'],
                                'server_name' => $data['display_name'],
                                'os_image' => 'Linux OS',
                                'region' => $data['region'],
                                'status' => 'contabo_ok',
                            ]);
                            $successCount++;
                        } else {
                            $lastError = $result->message;
                        }
                    }

                    if ($successCount > 0) {
                        $this->record->update(['status' => 'contabo_ok']);
                        Notification::make()->title('Provisioned on Contabo!')->success()->send();
                    } else {
                        $this->record->update(['status' => 'failed']);
                        Notification::make()->title('Provisioning Failed')->body($lastError)->danger()->send();
                    }
                }),

            Action::make('accept_and_deliver')
                ->label('Accept & Deliver')
                ->icon('heroicon-o-paper-airplane')
                ->color('success')
                ->requiresConfirmation()
                ->visible(fn () => $this->record->status === 'contabo_ok')
                ->action(function () {
                    $this->record->update(['status' => 'active']);
                    foreach ($this->record->services as $service) {
                        $service->update(['status' => 'active', 'next_due_date' => now()->addMonth()]);
                        try {
                            Mail::to($this->record->user->email)->send(new ServiceDeliveredMail(
                                $service,
                                $this->record->user,
                                $service->decrypted_password ?? 'N/A',
                                $service->default_user ?? 'root'
                            ));
                        } catch (\Exception $e) {}
                    }
                    Notification::make()->title('Service Delivered!')->success()->send();
                }),



            Action::make('sync_status')
                ->label('Sync Contabo Status')
                ->icon('heroicon-o-arrow-path')
                ->color('info')
                ->visible(fn () => $this->record->status === 'contabo_ok' && (empty($this->record->services->first()?->ip_address) || in_array($this->record->services->first()?->ip_address, ['Pending IP', 'Pending Assignment'])))
                ->action(function (ProvisioningServiceInterface $provisioningService) {
                    $service = $this->record->services->first();
                    if ($service && $service->contabo_instance_id) {
                        $result = $provisioningService->getInstance($service->contabo_instance_id);
                        $fetchedIp = $result->data['ipAddress'] ?? '';
                        
                        if ($result->success && !empty($fetchedIp) && !in_array($fetchedIp, ['Pending IP', 'Pending Assignment'])) {
                            $service->update(['ip_address' => $fetchedIp]);
                            Notification::make()->title('IP Address Synced!')->success()->send();
                            return;
                        }
                    }
                    Notification::make()->title('Still Pending')->body('Contabo has not assigned an IP yet. Check your Contabo billing.')->warning()->send();
                }),

            \Filament\Actions\ActionGroup::make([
                Action::make('cancel_order')
                    ->label('Cancel Order')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Cancel Order')
                    ->visible(fn () => !in_array($this->record->status, ['cancelled', 'active']))
                    ->action(function () {
                        $this->record->update(['status' => 'cancelled']);
                        Notification::make()->title('Order Cancelled')->success()->send();
                    }),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->label('More Actions')
            ->icon('heroicon-m-ellipsis-vertical')
            ->color('gray'),
        ];
    }
}

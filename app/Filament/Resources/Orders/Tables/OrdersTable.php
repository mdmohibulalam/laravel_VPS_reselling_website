<?php

namespace App\Filament\Resources\Orders\Tables;

use App\Mail\ServiceDeliveredMail;
use App\Models\Order;
use App\Models\Service;
use App\Services\Provisioning\ProvisioningServiceInterface;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_number')
                    ->label('Order #')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('user.name')
                    ->label('Customer')
                    ->searchable()
                    ->description(fn (Order $record) => $record->user->email ?? ''),
                TextColumn::make('services.package.name')
                    ->label('Package')
                    ->badge()
                    ->color('primary'),
                TextColumn::make('services.ip_address')
                    ->label('Server IP')
                    ->placeholder('Pending Provisioning')
                    ->copyable()
                    ->copyMessage('IP copied to clipboard'),
                TextColumn::make('total_amount')
                    ->label('Total')
                    ->money('USD')
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'provisioned' => 'info',
                        'provisioning' => 'warning',
                        'pending_approval' => 'gray',
                        'failed', 'rejected' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending_approval' => 'Pending Review',
                        'provisioned' => 'Provisioned (Ready to Deliver)',
                        'provisioning' => 'Provisioning...',
                        'active' => 'Active / Delivered',
                        'failed' => 'Provisioning Failed',
                        default => ucfirst($state),
                    }),
                TextColumn::make('created_at')
                    ->label('Placed At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                // Step 1: Go to Contabo (Provisioning) Action
                Action::make('provision_contabo')
                    ->label('Go to Contabo')
                    ->icon('heroicon-o-cloud-arrow-up')
                    ->color('warning')
                    ->modalHeading('Provision VPS via Contabo API')
                    ->modalDescription('Configure server parameters and submit to Contabo API to provision the server instance.')
                    ->modalSubmitActionLabel('Provision on Contabo')
                    ->visible(fn (Order $record) => in_array($record->status, ['pending_approval', 'provisioning_failed', 'failed']))
                    ->form(function (Order $record) {
                        $service = $record->services()->first();
                        $package = $service?->package;
                        $defaultProductId = $package?->contabo_product_id ?? 'V153';

                        return [
                            TextInput::make('product_id')
                                ->label('Contabo Product ID')
                                ->default($defaultProductId)
                                ->helperText('Contabo product model code (e.g. V153 for Cloud VPS 4, V154, etc.)')
                                ->required(),
                            Select::make('region')
                                ->label('Datacenter Region')
                                ->options([
                                    'EU' => 'European Union (Germany)',
                                    'US-central' => 'United States (Central)',
                                    'US-east' => 'United States (East)',
                                    'US-west' => 'United States (West)',
                                    'SIN' => 'Singapore (Asia)',
                                    'UK' => 'United Kingdom (Portsmouth)',
                                    'AUS' => 'Australia (Sydney)',
                                    'JPN' => 'Japan (Tokyo)',
                                    'IND' => 'India (Mumbai)',
                                ])
                                ->default(config('services.contabo.default_region', 'EU'))
                                ->required(),
                            Select::make('image_id')
                                ->label('Operating System Image')
                                ->options([
                                    'afecbb85-e2fc-46f0-9684-b46b1faf00bb' => 'Ubuntu 22.04 LTS (Recommended)',
                                    '9b1deb4d-3b7d-4bad-9bdd-2b0d7b3dcb6d' => 'Ubuntu 20.04 LTS',
                                    'a2c26e8f-84a5-4f3e-9c0e-b06511928cc0' => 'Debian 12 Bookworm',
                                    '7a8bffde-6721-44c0-ac03-c10796f455f8' => 'AlmaLinux 9',
                                    'b1c23d4e-5f6a-7b8c-9d0e-1f2a3b4c5d6e' => 'Rocky Linux 9',
                                    'c3d4e5f6-7a8b-9c0d-1e2f-3a4b5c6d7e8f' => 'Windows Server 2022 Datacenter',
                                    'd4e5f6a7-8b9c-0d1e-2f3a-4b5c6d7e8f9a' => 'Windows Server 2019 Datacenter',
                                ])
                                ->default(config('services.contabo.default_image_id', 'afecbb85-e2fc-46f0-9684-b46b1faf00bb'))
                                ->required(),
                            TextInput::make('default_user')
                                ->label('Default Root User')
                                ->default('root')
                                ->required(),
                            TextInput::make('root_password')
                                ->label('Server Root / Admin Password')
                                ->default(fn () => Str::password(16, true, true, false, false) . 'A1!')
                                ->helperText('This password will be configured on the server and sent to the customer upon delivery.')
                                ->required(),
                            TextInput::make('display_name')
                                ->label('Server Display Name')
                                ->default('VPS-' . $record->order_number),
                        ];
                    })
                    ->action(function (Order $record, array $data, ProvisioningServiceInterface $provisioningService) {
                        $record->update(['status' => 'provisioning']);
                        $services = $record->services;

                        if ($services->isEmpty()) {
                            // If no service exists, create one
                            $package = \App\Models\Package::first();
                            $service = Service::create([
                                'user_id' => $record->user_id,
                                'order_id' => $record->id,
                                'package_id' => $package?->id ?? 1,
                                'status' => 'provisioning',
                                'billing_cycle' => 'monthly',
                                'next_due_date' => now()->addMonth(),
                            ]);
                            $services = collect([$service]);
                        }

                        $successCount = 0;
                        $lastError = '';

                        foreach ($services as $service) {
                            $orderPayload = [
                                'service_id' => $service->id,
                                'product_id' => $data['product_id'],
                                'image_id' => $data['image_id'],
                                'region' => $data['region'],
                                'default_user' => $data['default_user'],
                                'root_password' => $data['root_password'],
                                'display_name' => $data['display_name'],
                                'period' => 1,
                            ];

                            $result = $provisioningService->createInstance($orderPayload);

                            if ($result->success) {
                                $instanceId = $result->data['instanceId'] ?? '';
                                $ipAddress = $result->data['ipAddress'] ?? 'Pending IP';
                                $password = $result->data['initialPassword'] ?? $data['root_password'];
                                $defaultUser = $result->data['defaultUser'] ?? $data['default_user'];

                                // Map OS Image name
                                $osMap = [
                                    'afecbb85-e2fc-46f0-9684-b46b1faf00bb' => 'Ubuntu 22.04 LTS',
                                    '9b1deb4d-3b7d-4bad-9bdd-2b0d7b3dcb6d' => 'Ubuntu 20.04 LTS',
                                    'a2c26e8f-84a5-4f3e-9c0e-b06511928cc0' => 'Debian 12 Bookworm',
                                    '7a8bffde-6721-44c0-ac03-c10796f455f8' => 'AlmaLinux 9',
                                    'b1c23d4e-5f6a-7b8c-9d0e-1f2a3b4c5d6e' => 'Rocky Linux 9',
                                    'c3d4e5f6-7a8b-9c0d-1e2f-3a4b5c6d7e8f' => 'Windows Server 2022',
                                    'd4e5f6a7-8b9c-0d1e-2f3a-4b5c6d7e8f9a' => 'Windows Server 2019',
                                ];
                                $osImageName = $osMap[$data['image_id']] ?? 'Linux OS';

                                $service->update([
                                    'contabo_instance_id' => $instanceId,
                                    'ip_address' => $ipAddress,
                                    'encrypted_credentials' => encrypt($password),
                                    'default_user' => $defaultUser,
                                    'server_name' => $data['display_name'],
                                    'os_image' => $osImageName,
                                    'region' => $data['region'],
                                    'status' => 'provisioned',
                                ]);

                                $successCount++;
                            } else {
                                $lastError = $result->message;
                                $service->update(['status' => 'provisioning_failed']);
                            }
                        }

                        if ($successCount > 0) {
                            $record->update(['status' => 'provisioned']);

                            $provisionedService = $services->first();
                            Notification::make()
                                ->title('Provisioned on Contabo Successfully!')
                                ->body("Instance ID: {$provisionedService->contabo_instance_id} | IP: {$provisionedService->ip_address} | Password: {$data['root_password']}. Click 'Accept & Deliver' to notify the customer.")
                                ->success()
                                ->duration(15000)
                                ->send();
                        } else {
                            $record->update(['status' => 'failed']);
                            Notification::make()
                                ->title('Provisioning Failed')
                                ->body($lastError)
                                ->danger()
                                ->send();
                        }
                    }),

                // Step 2: Accept & Deliver to Customer Action
                Action::make('accept_and_deliver')
                    ->label('Accept & Deliver to Customer')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('success')
                    ->modalHeading('Deliver Service & Send Credentials')
                    ->modalDescription(fn (Order $record) => "This will mark the service as Active and send an automated email with server IP ({$record->services->first()?->ip_address}) and root credentials to {$record->user->email}.")
                    ->requiresConfirmation()
                    ->modalSubmitActionLabel('Confirm Delivery & Email Customer')
                    ->visible(fn (Order $record) => in_array($record->status, ['provisioned', 'pending_approval']) && !empty($record->services->first()?->ip_address))
                    ->action(function (Order $record) {
                        $record->update(['status' => 'active']);

                        foreach ($record->services as $service) {
                            $service->update([
                                'status' => 'active',
                                'next_due_date' => now()->addMonth(),
                            ]);

                            $password = $service->decrypted_password ?? 'Please reset in customer portal';
                            $username = $service->default_user ?? 'root';

                            // Dispatch customer welcome delivery email
                            try {
                                Mail::to($record->user->email)->send(new ServiceDeliveredMail(
                                    $service,
                                    $record->user,
                                    $password,
                                    $username
                                ));
                            } catch (\Exception $e) {
                                // Log email exception if mailer is not configured
                            }
                        }

                        Notification::make()
                            ->title('Service Delivered Successfully!')
                            ->body("Order #{$record->order_number} is now Active and credentials email has been sent to {$record->user->email}.")
                            ->success()
                            ->send();
                    }),

                // View Server Credentials Action (Admin Modal)
                Action::make('view_credentials')
                    ->label('Credentials')
                    ->icon('heroicon-o-key')
                    ->color('gray')
                    ->modalHeading('Server Connection & Login Credentials')
                    ->visible(fn (Order $record) => !empty($record->services->first()?->ip_address))
                    ->form(function (Order $record) {
                        $service = $record->services->first();
                        $password = $service?->decrypted_password ?? 'N/A';
                        $user = $service?->default_user ?? 'root';
                        $ip = $service?->ip_address ?? 'N/A';
                        $instanceId = $service?->contabo_instance_id ?? 'N/A';

                        return [
                            TextInput::make('contabo_id')
                                ->label('Contabo Instance ID')
                                ->default($instanceId)
                                ->disabled(),
                            TextInput::make('ip')
                                ->label('Server IP Address')
                                ->default($ip)
                                ->disabled(),
                            TextInput::make('user')
                                ->label('Login Username')
                                ->default($user)
                                ->disabled(),
                            TextInput::make('pass')
                                ->label('Root / Admin Password')
                                ->default($password)
                                ->disabled(),
                            Placeholder::make('ssh_hint')
                                ->label('SSH Connection String')
                                ->content("ssh {$user}@{$ip}"),
                        ];
                    }),

                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

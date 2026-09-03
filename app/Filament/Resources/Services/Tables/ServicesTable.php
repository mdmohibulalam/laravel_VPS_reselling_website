<?php

namespace App\Filament\Resources\Services\Tables;

use App\Models\Service;
use App\Services\Provisioning\ProvisioningServiceInterface;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ServicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable()
                    ->description(fn (Service $record) => $record->user->email ?? ''),
                TextColumn::make('package.name')
                    ->label('Package')
                    ->badge()
                    ->color('primary')
                    ->searchable(),
                TextColumn::make('ip_address')
                    ->label('Server IP')
                    ->searchable()
                    ->copyable()
                    ->placeholder('Not Assigned')
                    ->weight('bold'),
                TextColumn::make('contabo_instance_id')
                    ->label('Contabo ID')
                    ->searchable()
                    ->placeholder('N/A'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'contabo_ok' => 'info',
                        'provisioning' => 'warning',
                        'suspended' => 'danger',
                        'terminated', 'cancelled' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'provisioning' => 'Provisioning',
                        'contabo_ok' => 'Contabo OK',
                        'active' => 'Active',
                        'suspended' => 'Suspended',
                        'terminated' => 'Terminated',
                        'cancelled' => 'Cancelled',
                        default => ucfirst($state),
                    }),
                TextColumn::make('recurring_amount')
                    ->label('Renewal Rate')
                    ->money('USD')
                    ->sortable(),
                TextColumn::make('billing_cycle')
                    ->label('Cycle')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                TextColumn::make('next_due_date')
                    ->label('Next Due Date')
                    ->date()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                // Credentials Action
                Action::make('credentials')
                    ->label('Credentials')
                    ->icon('heroicon-o-key')
                    ->color('info')
                    ->modalHeading('VPS Login Credentials')
                    ->visible(fn (Service $record) => !empty($record->ip_address))
                    ->form(function (Service $record) {
                        $pass = $record->decrypted_password ?? 'N/A';
                        $user = $record->default_user ?? 'root';
                        $ip = $record->ip_address ?? 'N/A';

                        return [
                            TextInput::make('ip')
                                ->label('Primary IP Address')
                                ->default($ip)
                                ->disabled(),
                            TextInput::make('user')
                                ->label('Login Username')
                                ->default($user)
                                ->disabled(),
                            TextInput::make('password')
                                ->label('Root / Admin Password')
                                ->default($pass)
                                ->disabled(),
                            Placeholder::make('ssh')
                                ->label('SSH Connection Command')
                                ->content("ssh {$user}@{$ip}"),
                        ];
                    }),

                // Power Actions Group
                ActionGroup::make([
                    Action::make('start')
                        ->label('Power On')
                        ->icon('heroicon-o-play')
                        ->color('success')
                        ->requiresConfirmation()
                        ->visible(fn (Service $record) => !empty($record->contabo_instance_id))
                        ->action(function (Service $record, ProvisioningServiceInterface $service) {
                            $res = $service->startInstance($record->contabo_instance_id);
                            if ($res->success) {
                                Notification::make()->title('Server Powered On')->success()->send();
                            } else {
                                Notification::make()->title('Failed')->body($res->message)->danger()->send();
                            }
                        }),

                    Action::make('stop')
                        ->label('Power Off (Force Stop)')
                        ->icon('heroicon-o-stop')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->visible(fn (Service $record) => !empty($record->contabo_instance_id))
                        ->action(function (Service $record, ProvisioningServiceInterface $service) {
                            $res = $service->stopInstance($record->contabo_instance_id);
                            if ($res->success) {
                                Notification::make()->title('Server Powered Off')->success()->send();
                            } else {
                                Notification::make()->title('Failed')->body($res->message)->danger()->send();
                            }
                        }),

                    Action::make('restart')
                        ->label('Reboot / Restart')
                        ->icon('heroicon-o-arrow-path')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->visible(fn (Service $record) => !empty($record->contabo_instance_id))
                        ->action(function (Service $record, ProvisioningServiceInterface $service) {
                            $res = $service->rebootInstance($record->contabo_instance_id);
                            if ($res->success) {
                                Notification::make()->title('Server Reboot Initiated')->success()->send();
                            } else {
                                Notification::make()->title('Failed')->body($res->message)->danger()->send();
                            }
                        }),

                    Action::make('shutdown')
                        ->label('Graceful Shutdown')
                        ->icon('heroicon-o-power')
                        ->color('gray')
                        ->requiresConfirmation()
                        ->visible(fn (Service $record) => !empty($record->contabo_instance_id))
                        ->action(function (Service $record, ProvisioningServiceInterface $service) {
                            $res = $service->shutdownInstance($record->contabo_instance_id);
                            if ($res->success) {
                                Notification::make()->title('Shutdown Signal Sent')->success()->send();
                            } else {
                                Notification::make()->title('Failed')->body($res->message)->danger()->send();
                            }
                        }),

                    Action::make('reset_password')
                        ->label('Reset Root Password')
                        ->icon('heroicon-o-lock-closed')
                        ->color('warning')
                        ->form([
                            TextInput::make('new_password')
                                ->label('New Root Password')
                                ->default(fn () => Str::password(16, true, true, false, false) . 'A1!')
                                ->required(),
                        ])
                        ->action(function (Service $record, array $data, ProvisioningServiceInterface $service) {
                            $res = $service->resetPassword($record->contabo_instance_id, $data['new_password']);
                            if ($res->success) {
                                $record->update(['encrypted_credentials' => encrypt($data['new_password'])]);
                                Notification::make()->title('Password Reset Successful')->body("New password: {$data['new_password']}")->success()->send();
                            } else {
                                Notification::make()->title('Password Reset Failed')->body($res->message)->danger()->send();
                            }
                        }),

                    Action::make('rescue')
                        ->label('Boot into Rescue Mode')
                        ->icon('heroicon-o-lifebuoy')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->form([
                            TextInput::make('rescue_password')
                                ->label('Rescue Mode Password')
                                ->default(fn () => Str::password(16, true, true, false, false) . 'A1!')
                                ->required(),
                        ])
                        ->action(function (Service $record, array $data, ProvisioningServiceInterface $service) {
                            $res = $service->rescueInstance($record->contabo_instance_id, $data['rescue_password']);
                            if ($res->success) {
                                Notification::make()->title('Server in Rescue Mode')->body("Rescue Password: {$data['rescue_password']}")->warning()->send();
                            } else {
                                Notification::make()->title('Rescue Mode Failed')->body($res->message)->danger()->send();
                            }
                        }),
                ])
                    ->label('Actions')
                    ->icon('heroicon-m-ellipsis-vertical')
                    ->size('sm'),

                Action::make('adjust_rate')
                    ->label('Adjust Rate')
                    ->icon('heroicon-o-currency-dollar')
                    ->color('warning')
                    ->modalHeading('Adjust Service Recurring Renewal Rate')
                    ->modalDescription('Manually increase or decrease this client\'s recurring renewal fee for upcoming billing cycles.')
                    ->form([
                        TextInput::make('recurring_amount')
                            ->label('New Recurring Renewal Amount ($)')
                            ->prefix('$')
                            ->numeric()
                            ->default(fn (Service $record) => $record->recurring_amount)
                            ->required(),
                    ])
                    ->action(function (Service $record, array $data) {
                        $oldRate = $record->recurring_amount;
                        $record->update(['recurring_amount' => $data['recurring_amount']]);
                        Notification::make()
                            ->title('Renewal Rate Adjusted')
                            ->body("Service #{$record->id} rate changed from \${$oldRate} to \${$data['recurring_amount']}.")
                            ->success()
                            ->send();
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

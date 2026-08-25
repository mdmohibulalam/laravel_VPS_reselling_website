<?php

namespace App\Filament\Resources\Orders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('order_number')
                    ->searchable(),
                TextColumn::make('total_amount')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                \Filament\Actions\Action::make('approve_provision')
                    ->label('Approve & Provision')
                    ->icon('heroicon-m-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (\App\Models\Order $record) => $record->status === 'pending_approval')
                    ->action(function (\App\Models\Order $record) {
                        $record->update(['status' => 'provisioning']);
                        
                        // Dispatch jobs for each service attached to the order
                        $services = \App\Models\Service::where('order_id', $record->id)->get();
                        foreach ($services as $service) {
                            \App\Jobs\ProvisioningJob::dispatch($service->id, 'create', [
                                'api_payload' => [
                                    // Generate payload for Contabo API from the package info
                                    // Normally you'd build this from the package's contabo_product_id
                                ]
                            ]);
                        }
                        
                        \Filament\Notifications\Notification::make()
                            ->title('Order Approved & Provisioning Started')
                            ->success()
                            ->send();
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

<?php

namespace App\Filament\Resources\Services\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('General Service Information')
                    ->schema([
                        Select::make('user_id')
                            ->label('Customer')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->required(),
                        Select::make('package_id')
                            ->label('Package Plan')
                            ->relationship('package', 'name')
                            ->searchable()
                            ->required(),
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'awaiting_provisioning' => 'Awaiting Provisioning',
                                'provisioned' => 'Provisioned',
                                'active' => 'Active',
                                'suspended' => 'Suspended',
                                'terminated' => 'Terminated',
                                'provisioning_failed' => 'Provisioning Failed',
                            ])
                            ->required(),
                        Select::make('billing_cycle')
                            ->label('Billing Cycle')
                            ->options([
                                'monthly' => 'Monthly',
                                'quarterly' => 'Quarterly',
                                'semi_annually' => 'Semi-Annually',
                                'annually' => 'Annually',
                            ])
                            ->required(),
                        DatePicker::make('next_due_date')
                            ->label('Next Due Date'),
                    ])
                    ->columns(2),

                Section::make('Contabo Instance & Server Details')
                    ->schema([
                        TextInput::make('contabo_instance_id')
                            ->label('Contabo Instance ID'),
                        TextInput::make('ip_address')
                            ->label('Primary IP Address'),
                        TextInput::make('server_name')
                            ->label('Server Hostname / Display Name'),
                        TextInput::make('default_user')
                            ->label('Default Login User')
                            ->default('root'),
                        TextInput::make('os_image')
                            ->label('OS Distribution'),
                        TextInput::make('region')
                            ->label('Datacenter Region')
                            ->default('EU'),
                    ])
                    ->columns(2),
            ]);
    }
}

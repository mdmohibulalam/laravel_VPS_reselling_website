<?php

namespace App\Filament\Resources\Users\Infolists;

use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Account Details')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('name')
                                    ->label('Full Name')
                                    ->weight('bold')
                                    ->icon('heroicon-o-user'),
                                TextEntry::make('email')
                                    ->label('Email Address')
                                    ->copyable()
                                    ->icon('heroicon-o-envelope'),
                                TextEntry::make('is_suspended')
                                    ->label('Account Status')
                                    ->badge()
                                    ->color(fn ($state) => $state ? 'danger' : 'success')
                                    ->formatStateUsing(fn ($state) => $state ? 'Suspended' : 'Active'),
                                TextEntry::make('company_name')
                                    ->label('Company / Organization')
                                    ->placeholder('N/A')
                                    ->icon('heroicon-o-building-office'),
                                TextEntry::make('phone')
                                    ->label('Phone Number')
                                    ->placeholder('N/A')
                                    ->copyable()
                                    ->icon('heroicon-o-phone'),
                                TextEntry::make('email_verified_at')
                                    ->label('Email Verified At')
                                    ->dateTime()
                                    ->placeholder('Not Verified')
                                    ->icon('heroicon-o-check-badge')
                                    ->color(fn ($state) => empty($state) ? 'warning' : 'success'),
                            ]),
                    ]),

                Section::make('Billing & Physical Address')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('address')
                                    ->label('Street Address')
                                    ->placeholder('N/A')
                                    ->columnSpan(2),
                                TextEntry::make('city')
                                    ->label('City')
                                    ->placeholder('N/A'),
                                TextEntry::make('state')
                                    ->label('State / Province')
                                    ->placeholder('N/A'),
                                TextEntry::make('country')
                                    ->label('Country')
                                    ->badge()
                                    ->color('info')
                                    ->placeholder('N/A'),
                                TextEntry::make('zip_code')
                                    ->label('Postal / Zip Code')
                                    ->placeholder('N/A'),
                            ]),
                    ]),

                Section::make('Meta Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('created_at')
                                    ->label('Registered At')
                                    ->dateTime()
                                    ->icon('heroicon-o-calendar-days'),
                                TextEntry::make('updated_at')
                                    ->label('Last Updated')
                                    ->dateTime()
                                    ->icon('heroicon-o-clock'),
                            ]),
                    ])
                    ->collapsed(false),
            ]);
    }
}

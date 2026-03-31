<?php

namespace App\Filament\Resources\Packages\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PackageForm
{
    public static function configure(Schema $schema): Schema

    {
        return $schema
            ->components([

                // 🟢 INFORMASI UTAMA
                Section::make('Informasi Paket')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Paket')
                            ->live(onBlur: true)
                            ->afterStateUpdated(
                                fn($state, callable $set) =>
                                $set('slug', Str::slug($state))
                            )
                            ->required(),

                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true),
                    ])
                    ->columns(2),

                // 🟡 JADWAL
                Section::make('Jadwal Keberangkatan')
                    ->schema([
                        DatePicker::make('departure_date')
                            ->label('Tanggal Berangkat')
                            ->required(),

                        DatePicker::make('return_date')
                            ->label('Tanggal Pulang')
                            ->required(),
                    ])
                    ->columns(2),

                // 🔵 HARGA
                Section::make('Harga Paket')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('price_quad')
                                    ->label('Quad (4 Orang)')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->required(),

                                TextInput::make('price_triple')
                                    ->label('Triple (3 Orang)')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->required(),

                                TextInput::make('price_double')
                                    ->label('Double (2 Orang)')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->required(),
                            ]),
                    ]),

                // 🟣 KUOTA
                Section::make('Kuota & Kursi')
                    ->schema([
                        TextInput::make('quota')
                            ->label('Total Kuota')
                            ->numeric()
                            ->live()
                            ->afterStateUpdated(
                                fn($state, callable $set) =>
                                $set('available_seats', $state)
                            )
                            ->required(),

                        TextInput::make('available_seats')
                            ->label('Sisa Kursi')
                            ->numeric()
                            ->disabled(),
                    ])
                    ->columns(2),

                // 🔴 DETAIL PERJALANAN
                Section::make('Detail Perjalanan')
                    ->schema([
                        TextInput::make('airline')
                            ->label('Maskapai')
                            ->required(),

                        TextInput::make('hotel_makkah')
                            ->label('Hotel Makkah')
                            ->required(),

                        TextInput::make('hotel_madinah')
                            ->label('Hotel Madinah')
                            ->required(),
                    ])
                    ->columns(3),

                // ⚫ STATUS
                Section::make('Status')
                    ->schema([
                        Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Published',
                                'closed' => 'Closed',
                            ])
                            ->default('draft')
                            ->required(),
                    ]),
            ]);
    }
}

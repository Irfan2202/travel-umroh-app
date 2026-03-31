<?php

namespace App\Filament\Resources\Packages\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Schemas\Components\View;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;

class PackagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // 🟢 NAMA & MASKAPAI
                TextColumn::make('name')
                    ->label('Nama Paket')
                    ->description(fn($record) => "Maskapai: " . $record->airline)
                    ->searchable()
                    ->sortable(),

                // 🟡 JADWAL & DURASI
                TextColumn::make('departure_date')
                    ->label('Keberangkatan')
                    ->date('d M Y')
                    ->description(function ($record) {
                        $start = Carbon::parse($record->departure_date);
                        $end = Carbon::parse($record->return_date);
                        return $start->diffInDays($end) . ' Hari';
                    })
                    ->sortable(),

                // 🔵 HARGA TERENDAH (QUAD)
                TextColumn::make('price_quad')
                    ->label('Mulai Dari')
                    ->money('IDR')
                    ->color('success')
                    ->weight('bold')
                    ->sortable(),

                // 🟣 SISA KURSI / KUOTA
                TextColumn::make('available_seats')
                    ->label('Sisa Kursi')
                    ->description(fn($record) => "Total Kuota: {$record->quota}")
                    ->numeric()
                    ->alignCenter()
                    ->badge()
                    ->color(fn(int $state): string => match (true) {
                        $state <= 5 => 'danger',
                        $state <= 15 => 'warning',
                        default => 'success',
                    })
                    ->sortable(),

                // 🔴 HOTEL (MAKKAH)
                TextColumn::make('hotel_makkah')
                    ->label('Hotel Makkah')
                    ->description(fn($record) => "Madinah: " . $record->hotel_madinah)
                    ->toggleable(),

                // ⚫ STATUS
                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'published' => 'success',
                        'draft' => 'gray',
                        'closed' => 'danger',
                        default => 'secondary',
                    })
                    ->formatStateUsing(fn(string $state): string => ucfirst($state)),
            ])

            ->filters([
                //
            ])
            ->recordActions([

                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),

            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

<?php

namespace App\Filament\Resources\Customers\Tables;

use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CustomersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->weight('semibold'),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('phone')
                    ->placeholder('—'),
                TextColumn::make('orders_count')
                    ->counts('orders')
                    ->label('Orders')
                    ->badge(),
                TextColumn::make('created_at')
                    ->label('Joined')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([]);
    }
}

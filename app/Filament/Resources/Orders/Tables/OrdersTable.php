<?php

namespace App\Filament\Resources\Orders\Tables;

use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('order_number')
                    ->label('Order #')
                    ->searchable()
                    ->weight('semibold'),
                TextColumn::make('customer_name')
                    ->label('Customer')
                    ->description(fn ($record) => $record->customer_email)
                    ->searchable(),
                TextColumn::make('total')
                    ->money('LKR')
                    ->sortable(),
                TextColumn::make('payment_method')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'cod' => 'Cash on Delivery',
                        'bank_transfer' => 'Bank Transfer',
                        'payhere' => 'PayHere',
                        default => $state,
                    }),
                TextColumn::make('payment_status')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'paid' => 'success',
                        'pending' => 'warning',
                        'failed', 'refunded' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'delivered' => 'success',
                        'processing', 'shipped' => 'info',
                        'cancelled' => 'danger',
                        default => 'warning',
                    }),
                TextColumn::make('created_at')
                    ->label('Placed at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'processing' => 'Processing',
                        'shipped' => 'Shipped',
                        'delivered' => 'Delivered',
                        'cancelled' => 'Cancelled',
                    ]),
                SelectFilter::make('payment_status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'failed' => 'Failed',
                        'refunded' => 'Refunded',
                    ]),
                SelectFilter::make('payment_method')
                    ->options([
                        'cod' => 'Cash on Delivery',
                        'bank_transfer' => 'Bank Transfer',
                        'payhere' => 'PayHere',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([]);
    }
}

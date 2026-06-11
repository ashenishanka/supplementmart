<?php

namespace App\Filament\Resources\Customers\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrdersRelationManager extends RelationManager
{
    protected static string $relationship = 'orders';

    public function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('order_number')
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('order_number')->label('Order #'),
                TextColumn::make('total')->money('LKR'),
                TextColumn::make('status')->badge(),
                TextColumn::make('payment_status')->badge(),
                TextColumn::make('created_at')->label('Placed at')->dateTime(),
            ])
            ->headerActions([])
            ->recordActions([])
            ->toolbarActions([]);
    }
}

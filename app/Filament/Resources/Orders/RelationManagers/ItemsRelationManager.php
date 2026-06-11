<?php

namespace App\Filament\Resources\Orders\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    public function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('product_name')
            ->columns([
                TextColumn::make('product_name')
                    ->label('Product'),
                TextColumn::make('variant_name')
                    ->label('Variant')
                    ->placeholder('—'),
                TextColumn::make('sku')
                    ->label('SKU'),
                TextColumn::make('price')
                    ->money('LKR'),
                TextColumn::make('quantity')
                    ->numeric(),
                TextColumn::make('line_total')
                    ->label('Total')
                    ->money('LKR'),
            ])
            ->headerActions([])
            ->recordActions([])
            ->toolbarActions([]);
    }
}

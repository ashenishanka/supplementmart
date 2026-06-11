<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                ImageColumn::make('images.path')
                    ->label('Image')
                    ->limit(1)
                    ->circular(),
                TextColumn::make('name')
                    ->searchable()
                    ->weight('semibold')
                    ->description(fn ($record) => $record->sku),
                TextColumn::make('category.name')
                    ->searchable()
                    ->badge(),
                TextColumn::make('brand.name')
                    ->searchable()
                    ->placeholder('—'),
                TextColumn::make('price')
                    ->money('LKR')
                    ->sortable(),
                TextColumn::make('sale_price')
                    ->money('LKR')
                    ->placeholder('—')
                    ->sortable(),
                TextColumn::make('stock_quantity')
                    ->label('Stock')
                    ->numeric()
                    ->sortable()
                    ->color(fn (int $state) => $state > 0 ? 'success' : 'danger'),
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
                IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean(),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->relationship('category', 'name'),
                SelectFilter::make('brand')
                    ->relationship('brand', 'name'),
                TernaryFilter::make('is_active')
                    ->label('Active'),
                TernaryFilter::make('is_featured')
                    ->label('Featured'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

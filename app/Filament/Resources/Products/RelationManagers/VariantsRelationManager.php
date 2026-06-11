<?php

namespace App\Filament\Resources\Products\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class VariantsRelationManager extends RelationManager
{
    protected static string $relationship = 'variants';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->placeholder('e.g. 1kg - Chocolate')
                    ->required(),
                TextInput::make('sku')
                    ->label('SKU')
                    ->required(),
                TextInput::make('price')
                    ->label('Price (LKR)')
                    ->required()
                    ->numeric()
                    ->prefix('Rs.'),
                TextInput::make('sale_price')
                    ->label('Sale price (LKR)')
                    ->numeric()
                    ->prefix('Rs.'),
                TextInput::make('stock_quantity')
                    ->label('Stock quantity')
                    ->required()
                    ->numeric()
                    ->default(0),
                KeyValue::make('attributes')
                    ->keyLabel('Attribute')
                    ->valueLabel('Value')
                    ->columnSpanFull(),
                Toggle::make('is_default')
                    ->label('Default variant')
                    ->default(false),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable(),
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
                    ->sortable(),
                IconColumn::make('is_default')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
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

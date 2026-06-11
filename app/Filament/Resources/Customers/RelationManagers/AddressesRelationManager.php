<?php

namespace App\Filament\Resources\Customers\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AddressesRelationManager extends RelationManager
{
    protected static string $relationship = 'addresses';

    public function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('recipient_name')
            ->columns([
                TextColumn::make('label')->placeholder('—'),
                TextColumn::make('recipient_name')->label('Recipient'),
                TextColumn::make('phone'),
                TextColumn::make('address_line1')->label('Address'),
                TextColumn::make('city'),
                TextColumn::make('district'),
                IconColumn::make('is_default')->boolean(),
            ])
            ->headerActions([])
            ->recordActions([])
            ->toolbarActions([]);
    }
}

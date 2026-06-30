<?php

namespace App\Filament\Resources\Admins\Tables;

use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AdminsTable
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
                IconColumn::make('root')
                    ->label('Root')
                    ->boolean()
                    ->state(fn (User $record): bool => $record->isProtectedRootAdmin()),
                TextColumn::make('created_at')
                    ->label('Joined')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                    ->visible(fn (User $record): bool => ! $record->isProtectedRootAdmin()),
                DeleteAction::make()
                    ->visible(fn (User $record): bool => ! $record->isProtectedRootAdmin()),
            ])
            ->toolbarActions([]);
    }
}

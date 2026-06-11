<?php

namespace App\Filament\Resources\Customers\Pages;

use App\Filament\Resources\Customers\CustomerResource;
use Filament\Actions\EditAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ViewCustomer extends ViewRecord
{
    protected static string $resource = CustomerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Customer details')
                    ->columns(3)
                    ->components([
                        TextEntry::make('name'),
                        TextEntry::make('email'),
                        TextEntry::make('phone')->placeholder('—'),
                        TextEntry::make('created_at')->label('Joined')->dateTime(),
                    ]),
            ]);
    }
}

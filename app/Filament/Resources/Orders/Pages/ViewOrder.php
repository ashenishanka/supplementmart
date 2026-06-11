<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use Filament\Actions\EditAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

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
                Grid::make(3)
                    ->components([
                        Section::make('Order')
                            ->columnSpan(1)
                            ->components([
                                TextEntry::make('order_number')->label('Order #'),
                                TextEntry::make('status')->badge(),
                                TextEntry::make('payment_method')
                                    ->formatStateUsing(fn (string $state) => match ($state) {
                                        'cod' => 'Cash on Delivery',
                                        'bank_transfer' => 'Bank Transfer',
                                        'payhere' => 'PayHere',
                                        default => $state,
                                    }),
                                TextEntry::make('payment_status')->badge(),
                                TextEntry::make('created_at')->label('Placed at')->dateTime(),
                            ]),
                        Section::make('Customer')
                            ->columnSpan(1)
                            ->components([
                                TextEntry::make('customer_name')->label('Name'),
                                TextEntry::make('customer_email')->label('Email'),
                                TextEntry::make('customer_phone')->label('Phone'),
                                TextEntry::make('user.name')->label('Account')->placeholder('Guest'),
                            ]),
                        Section::make('Shipping address')
                            ->columnSpan(1)
                            ->components([
                                TextEntry::make('shipping_address.recipient_name')->label('Recipient'),
                                TextEntry::make('shipping_address.phone')->label('Phone'),
                                TextEntry::make('shipping_address.address_line1')->label('Address line 1'),
                                TextEntry::make('shipping_address.address_line2')->label('Address line 2')->placeholder('—'),
                                TextEntry::make('shipping_address.city')->label('City'),
                                TextEntry::make('shipping_address.district')->label('District'),
                                TextEntry::make('shipping_address.postal_code')->label('Postal code')->placeholder('—'),
                            ]),
                    ]),
                Section::make('Totals')
                    ->columns(3)
                    ->components([
                        TextEntry::make('subtotal')->money('LKR'),
                        TextEntry::make('shipping_fee')->label('Shipping')->money('LKR'),
                        TextEntry::make('total')->money('LKR'),
                    ]),
                Section::make('Notes')
                    ->visible(fn ($record) => filled($record->notes))
                    ->components([
                        TextEntry::make('notes')->hiddenLabel(),
                    ]),
            ]);
    }
}

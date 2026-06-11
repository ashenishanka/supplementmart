<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use BackedEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ManageSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected string $view = 'filament.pages.manage-settings';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    /**
     * @var array<string, mixed>
     */
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'store_name' => Setting::get('store_name', config('app.name')),
            'store_phone' => Setting::get('store_phone'),
            'store_email' => Setting::get('store_email'),
            'store_address' => Setting::get('store_address'),
            'bank_name' => Setting::get('bank_name'),
            'bank_account_name' => Setting::get('bank_account_name'),
            'bank_account_number' => Setting::get('bank_account_number'),
            'bank_branch' => Setting::get('bank_branch'),
            'shipping_fee' => Setting::get('shipping_fee', '0'),
            'free_shipping_threshold' => Setting::get('free_shipping_threshold'),
            'payhere_merchant_id' => Setting::get('payhere_merchant_id'),
            'payhere_merchant_secret' => Setting::get('payhere_merchant_secret'),
            'payhere_mode' => Setting::get('payhere_mode', 'sandbox'),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Section::make('Store information')
                    ->columns(2)
                    ->components([
                        TextInput::make('store_name')
                            ->label('Store name')
                            ->required(),
                        TextInput::make('store_phone')
                            ->label('Contact phone')
                            ->tel(),
                        TextInput::make('store_email')
                            ->label('Contact email')
                            ->email(),
                        Textarea::make('store_address')
                            ->label('Store address')
                            ->columnSpanFull(),
                    ]),
                Section::make('Bank transfer details')
                    ->description('Shown to customers who choose Bank Transfer at checkout.')
                    ->columns(2)
                    ->components([
                        TextInput::make('bank_name'),
                        TextInput::make('bank_account_name')
                            ->label('Account name'),
                        TextInput::make('bank_account_number')
                            ->label('Account number'),
                        TextInput::make('bank_branch')
                            ->label('Branch'),
                    ]),
                Section::make('Shipping')
                    ->columns(2)
                    ->components([
                        TextInput::make('shipping_fee')
                            ->label('Shipping fee (LKR)')
                            ->numeric()
                            ->prefix('Rs.')
                            ->required(),
                        TextInput::make('free_shipping_threshold')
                            ->label('Free shipping over (LKR)')
                            ->numeric()
                            ->prefix('Rs.'),
                    ]),
                Section::make('PayHere payment gateway')
                    ->description('Merchant credentials from your PayHere account.')
                    ->columns(2)
                    ->components([
                        TextInput::make('payhere_merchant_id')
                            ->label('Merchant ID'),
                        TextInput::make('payhere_merchant_secret')
                            ->label('Merchant secret')
                            ->password()
                            ->revealable(),
                        Select::make('payhere_mode')
                            ->label('Mode')
                            ->options([
                                'sandbox' => 'Sandbox',
                                'live' => 'Live',
                            ])
                            ->required(),
                    ]),
            ]);
    }

    public function save(): void
    {
        foreach ($this->form->getState() as $key => $value) {
            Setting::set($key, $value);
        }

        Notification::make()
            ->title('Settings saved')
            ->success()
            ->send();
    }
}

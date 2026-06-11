<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Models\Product;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Set;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Product details')
                    ->columns(2)
                    ->components([
                        TextInput::make('name')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $state, Set $set) => $set('slug', Str::slug($state)))
                            ->columnSpanFull(),
                        TextInput::make('slug')
                            ->required()
                            ->unique(Product::class, 'slug', ignoreRecord: true),
                        TextInput::make('sku')
                            ->label('SKU')
                            ->required()
                            ->unique(Product::class, 'sku', ignoreRecord: true),
                        Select::make('category_id')
                            ->label('Category')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('brand_id')
                            ->label('Brand')
                            ->relationship('brand', 'name')
                            ->searchable()
                            ->preload(),
                        Textarea::make('short_description')
                            ->rows(2)
                            ->columnSpanFull(),
                        Textarea::make('description')
                            ->rows(5)
                            ->columnSpanFull(),
                    ]),
                Section::make('Pricing & inventory')
                    ->columns(2)
                    ->components([
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
                        Toggle::make('is_active')
                            ->label('Active (visible in store)')
                            ->default(true),
                        Toggle::make('is_featured')
                            ->label('Featured product')
                            ->default(false),
                    ]),
                Section::make('SEO')
                    ->columns(2)
                    ->collapsed()
                    ->components([
                        TextInput::make('meta_title'),
                        TextInput::make('meta_description'),
                    ]),
            ]);
    }
}

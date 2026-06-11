<?php

namespace App\Filament\Resources\Brands\Schemas;

use App\Models\Brand;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class BrandForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (string $state, Set $set) => $set('slug', Str::slug($state))),
                TextInput::make('slug')
                    ->required()
                    ->unique(Brand::class, 'slug', ignoreRecord: true),
                FileUpload::make('logo')
                    ->image()
                    ->directory('brands'),
                Textarea::make('description')
                    ->columnSpanFull(),
                Toggle::make('is_active')
                    ->default(true),
            ]);
    }
}

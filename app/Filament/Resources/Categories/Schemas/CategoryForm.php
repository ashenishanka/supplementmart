<?php

namespace App\Filament\Resources\Categories\Schemas;

use App\Models\Category;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CategoryForm
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
                    ->unique(Category::class, 'slug', ignoreRecord: true),
                Select::make('parent_id')
                    ->label('Parent category')
                    ->relationship(
                        name: 'parent',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn ($query, ?Category $record) => $record
                            ? $query->whereKeyNot($record->getKey())
                            : $query,
                    )
                    ->searchable()
                    ->preload(),
                Textarea::make('description')
                    ->columnSpanFull(),
                FileUpload::make('image')
                    ->image()
                    ->directory('categories'),
                Toggle::make('is_active')
                    ->default(true),
                TextInput::make('sort_order')
                    ->numeric()
                    ->default(0),
            ]);
    }
}

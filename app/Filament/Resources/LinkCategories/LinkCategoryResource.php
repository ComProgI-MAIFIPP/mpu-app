<?php

namespace App\Filament\Resources\LinkCategories;

use App\Filament\Resources\LinkCategories\Pages\CreateLinkCategory;
use App\Filament\Resources\LinkCategories\Pages\EditLinkCategory;
use App\Filament\Resources\LinkCategories\Pages\ListLinkCategories;
use App\Filament\Resources\LinkCategories\Schemas\LinkCategoryForm;
use App\Filament\Resources\LinkCategories\Tables\LinkCategoriesTable;
use App\Models\LinkCategory;
use BackedEnum;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class LinkCategoryResource extends Resource
{
    protected static ?string $model = LinkCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Tag;

    protected static ?string $recordTitleAttribute = 'linkcategory';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Category Information')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('links_count')
                    ->counts('links')
                    ->label('Total Links')
                    ->badge()
                    ->color('primary'),
                IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),
                TextColumn::make('created_at')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('is_active')
                    ->options([
                        1 => 'Active',
                        0 => 'Inactive',
                    ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLinkCategories::route('/'),
            'create' => CreateLinkCategory::route('/create'),
            'edit' => EditLinkCategory::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources\LinkCategories;

use App\Filament\Resources\LinkCategories\Pages\CreateLinkCategory;
use App\Filament\Resources\LinkCategories\Pages\EditLinkCategory;
use App\Filament\Resources\LinkCategories\Pages\ListLinkCategories;
use App\Filament\Resources\LinkCategories\Schemas\LinkCategoryForm;
use App\Filament\Resources\LinkCategories\Tables\LinkCategoriesTable;
use App\Models\LinkCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LinkCategoryResource extends Resource
{
    protected static ?string $model = LinkCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Tag;

    protected static ?string $recordTitleAttribute = 'linkcategory';

    public static function form(Schema $schema): Schema
    {
        return LinkCategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LinkCategoriesTable::configure($table);
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

<?php

namespace App\Filament\Resources\LinkCategories\Pages;

use App\Filament\Resources\LinkCategories\LinkCategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLinkCategories extends ListRecords
{
    protected static string $resource = LinkCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

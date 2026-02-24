<?php

namespace App\Filament\Resources\LinkCategories\Pages;

use App\Filament\Resources\LinkCategories\LinkCategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLinkCategory extends EditRecord
{
    protected static string $resource = LinkCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\MonthlyStatistics\Pages;

use App\Filament\Resources\MonthlyStatistics\MonthlyStatisticResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMonthlyStatistics extends ListRecords
{
    protected static string $resource = MonthlyStatisticResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

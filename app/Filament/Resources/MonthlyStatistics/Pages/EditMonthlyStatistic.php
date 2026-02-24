<?php

namespace App\Filament\Resources\MonthlyStatistics\Pages;

use App\Filament\Resources\MonthlyStatistics\MonthlyStatisticResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMonthlyStatistic extends EditRecord
{
    protected static string $resource = MonthlyStatisticResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

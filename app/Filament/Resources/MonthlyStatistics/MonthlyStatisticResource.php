<?php

namespace App\Filament\Resources\MonthlyStatistics;

use App\Filament\Resources\MonthlyStatistics\Pages\CreateMonthlyStatistic;
use App\Filament\Resources\MonthlyStatistics\Pages\EditMonthlyStatistic;
use App\Filament\Resources\MonthlyStatistics\Pages\ListMonthlyStatistics;
use App\Filament\Resources\MonthlyStatistics\Schemas\MonthlyStatisticForm;
use App\Filament\Resources\MonthlyStatistics\Tables\MonthlyStatisticsTable;
use App\Models\MonthlyStatistic;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

class MonthlyStatisticResource extends Resource
{
    protected static ?string $model = MonthlyStatistic::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ChartPie;

    protected static ?string $recordTitleAttribute = 'monthlystatistics';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Monthly Statistics')
                    ->columns(2)
                    ->schema([

                        Select::make('year')
                            ->label('Year')
                            ->options(function () {
                                $currentYear = now()->year;
                                $startYear = 2020;
                                $years = range($currentYear + 1, $startYear);
                                return array_combine($years, $years);
                            })
                            ->default(now()->year)
                            ->required(),

                        Select::make('month')
                                ->label('Month')
                                ->options([
                                    1 => 'January',
                                    2 => 'February',
                                    3 => 'March',
                                    4 => 'April',
                                    5 => 'May',
                                    6 => 'June',
                                    7 => 'July',
                                    8 => 'August',
                                    9 => 'September',
                                    10 => 'October',
                                    11 => 'November',
                                    12 => 'December',
                                ])
                                ->default(now()->month)
                                ->required()
                                ->unique(
                                    table: 'monthly_statistics',
                                    column: 'month',
                                    modifyRuleUsing: function (Unique $rule, callable $get) {
                                        return $rule->where('year', $get('year'));
                                    }
                                ),
                                
                        TextInput::make('patients_served')
                            ->label('Patients Served')
                            ->numeric()
                            ->required()
                            ->minValue(0),

                        TextInput::make('utilized_funds')
                            ->label('Utilized Funds')
                            ->numeric()
                            ->prefix('₱')
                            ->required()
                            ->minValue(0),

                        TextInput::make('partner_facilities')
                            ->label('Partner Health Facilities')
                            ->numeric()
                            ->required()
                            ->minValue(0),

                        DatePicker::make('as_of_date')
                            ->label('As of Date')
                            ->required(),

                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('year', 'desc')
            ->columns([
                TextColumn::make('year')
                    ->sortable(),

                TextColumn::make('month_name')
                    ->label('Month')
                    ->sortable(),

                TextColumn::make('patients_served')
                    ->label('Patients Served')
                    ->sortable()
                    ->formatStateUsing(fn($state) => number_format($state)),

                TextColumn::make('utilized_funds')
                    ->label('Total Funds')
                    ->money('PHP')
                    ->sortable(),

                TextColumn::make('partner_facilities')
                    ->label('Partner Facilities')
                    ->sortable(),

                TextColumn::make('as_of_date')
                    ->date()
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
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
            'index' => ListMonthlyStatistics::route('/'),
            'create' => CreateMonthlyStatistic::route('/create'),
            'edit' => EditMonthlyStatistic::route('/{record}/edit'),
        ];
    }
}

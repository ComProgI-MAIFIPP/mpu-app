<?php

namespace App\Filament\Resources\Reminders;

use App\Filament\Resources\Reminders\Pages\CreateReminder;
use App\Filament\Resources\Reminders\Pages\EditReminder;
use App\Filament\Resources\Reminders\Pages\ListReminders;
use App\Filament\Resources\Reminders\Schemas\ReminderForm;
use App\Filament\Resources\Reminders\Tables\RemindersTable;
use App\Models\Reminder;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Text;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ReminderResource extends Resource
{
    protected static ?string $model = Reminder::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::InformationCircle;

    protected static ?string $recordTitleAttribute = 'reminder';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Reminder Details')
                    ->columns(2)
                    ->schema([

                        TextInput::make('title')
                            ->required()
                            ->columnSpanFull()
                            ->maxLength(255),

                        Textarea::make('description')
                            ->rows(4)
                            ->columnSpanFull()
                            ->maxLength(65535),
                        
                        DatePicker::make('event_date')
                            ->label('Event Date')
                            ->native(false)
                            ->required(),
                        
                        Select::make('type')
                            ->options([
                                'holiday' => 'Holiday',
                                'reminder' => 'Reminder',
                            ])
                            ->required()
                            ->native(false),
                        
                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->inline(false),
                        
                    ]) 
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(40),
                
                TextColumn::make('event_date')
                    ->date()
                    ->sortable(),
                
                TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->colors([
                        'success' => 'holiday',
                        'primary' => 'reminder',
                    ])
                    ->default('secondary')
                    ->formatStateUsing(fn ($state) => ucfirst($state)),
                
                IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),
                
                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime() // shows full timestamp
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->since()
                    ->sortable(),
            ])
            ->filters([
                
                SelectFilter::make('type')
                    ->options([
                        'holiday' => 'Holiday',
                        'reminder' => 'Reminder',
                    ]),
                
                SelectFilter::make('is_active')
                    ->options([
                        1 => 'Active',
                        0 => 'Inactive',
                    ]),
            ])
            ->defaultGroup('type')
            ->defaultSort('event_date', 'desc')
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
            'index' => ListReminders::route('/'),
            'create' => CreateReminder::route('/create'),
            'edit' => EditReminder::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources\Events;

use App\Filament\Resources\Events\Pages\CreateEvent;
use App\Filament\Resources\Events\Pages\EditEvent;
use App\Filament\Resources\Events\Pages\ListEvents;
use App\Filament\Resources\Events\Schemas\EventForm;
use App\Filament\Resources\Events\Tables\EventsTable;
use App\Models\Event;
use BackedEnum;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Factories\Relationship;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::CalendarDays;

    protected static ?string $recordTitleAttribute = 'Event';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Event Details')
                    ->schema([
                        TextInput::make('name')
                            ->label('Event Name')
                            ->required()
                            ->maxLength(255),
                        Grid::make(2)
                            ->schema([
                                DatePicker::make('start_date')
                                ->required(),
                                DatePicker::make('end_date')
                                ->required()
                                ->rule('after_or_equal:start_date'),
                            ]),
                            
                    ])
                    ->columns(1)
                    ->collapsible(false),
                Section::make('Event Photos')
                    ->schema([
                        Repeater::make('photos')
                            ->relationship()
                            ->maxItems(10)
                            ->reorderable('sort')
                            ->grid(3)
                            ->schema([
                                FileUpload::make('photo')
                                    ->image()
                                    ->required()
                                    ->directory('events')
                                    ->imagePreviewHeight(200)
                                    ->panelLayout('compact')
                                    ->openable()
                                    ->downloadable()
                                    ->removeUploadedFileButtonPosition('right'),
                            ])
                            ->columnSpanFull()
                            ->addActionLabel('Add Photo')
                            ->helperText('Maximum of 10 Photos'),
                ])
                ->columns(1)
                ->collapsible(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photos.photo')
                    ->circular()
                    ->stacked()
                    ->limit(3),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('start_date')
                    ->date(),
                TextColumn::make('end_date')
                    ->date(),
            ])
            ->recordActions([
                EditAction::make(),
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
            'index' => ListEvents::route('/'),
            'create' => CreateEvent::route('/create'),
            'edit' => EditEvent::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources\Links;

use App\Filament\Resources\Links\Pages\CreateLink;
use App\Filament\Resources\Links\Pages\EditLink;
use App\Filament\Resources\Links\Pages\ListLinks;
use App\Filament\Resources\Links\Schemas\LinkForm;
use App\Filament\Resources\Links\Tables\LinksTable;
use App\Models\Link;
use BackedEnum;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class LinkResource extends Resource
{
    protected static ?string $model = Link::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Link;

    protected static ?string $recordTitleAttribute = 'link';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Link Information')
                    ->columns(2)
                    ->schema([

                        Select::make('link_category_id')
                            ->label('Category')
                            ->relationship('Category', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        
                        TextInput::make('url')
                            ->label('Link')
                            ->required()
                            ->url()
                            ->columnSpanFull(),
                        
                        FileUpload::make('image')
                            ->image()
                            ->directory('links')
                            ->imagePreviewHeight(150)
                            ->nullable()
                            ->columnSpanFull(),

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

                ImageColumn::make('image')
                    ->square()
                    ->imageHeight(50),
                
                TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->limit(30),
                
                TextColumn::make('category.name')
                    ->label('Category')
                    ->badge()
                    ->sortable(),
                
                TextColumn::make('url')
                    ->limit(40)
                    ->url(fn ($record) => $record->url, true)
                    ->openUrlInNewTab(),
                
                IconColumn::make('is_active')
                    ->boolean()
                    ->label('active'),
                
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
                ->filters([

                    SelectFilter::make('link_category_id')
                        ->label('category')
                        ->relationship('category', 'name'),
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
            'index' => ListLinks::route('/'),
            'create' => CreateLink::route('/create'),
            'edit' => EditLink::route('/{record}/edit'),
        ];
    }
}

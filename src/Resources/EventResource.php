<?php

namespace Buildix\Timex\Resources;

use Carbon\Carbon;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Buildix\Timex\Resources\EventResource\Pages;

class EventResource extends Resource
{
    protected static ?string $recordTitleAttribute = 'subject';
    protected $chosenStartTime;

    public static function getModel(): string
    {
        return config('timex.models.event');
    }

    public static function getModelLabel(): string
    {
        return config('timex.models.label');
    }

    public static function getPluralModelLabel(): string
    {
        return config('timex.models.pluralLabel');
    }

    public static function getSlug(): string
    {
        return config('timex.resources.slug');
    }

    protected static function getNavigationGroup(): ?string
    {
        return config('timex.pages.group');
    }

    protected static function getNavigationIcon(): string
    {
        return config('timex.resources.icon');
    }

    protected static function shouldRegisterNavigation(): bool
    {
        return config('timex.resources.shouldRegisterNavigation');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('organizer'),
                TextInput::make('subject')->required()->columnSpanFull(),
                RichEditor::make('body')->columnSpanFull(),
                Select::make('category')->columnSpanFull()
                    ->searchable()
                    ->preload()
                    ->options(config('timex.categories.labels'))
                    ->columnSpanFull(),
                Grid::make(3)->schema([
                    Toggle::make('isAllDay')
                        ->columnSpanFull()
                        ->reactive()
                        ->afterStateUpdated(function ($set, callable $get, $state){
                            $start = today()->setHours(0)->setMinutes(0);
                            $end = today()->setHours(23)->setMinutes(59);
                            if ($state == true){
                                $set('startTime',$start);
                                $set('endTime',$end);
                            }else{
                                $set('startTime',now()->setMinutes(0)->addHour());
                                $set('endTime',now()->setMinutes(0)->addHour()->addMinutes(30));
                            }
                        }),
                    DatePicker::make('start')
                        ->inlineLabel()
                        ->columnSpan(2)
                        ->default(today())
                        ->minDate(today())
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function ($get,$set,$state){
                            if ($get('end') < $state){
                                $set('end',$state);
                            }
                        })
                        ->extraAttributes([
                            'class' => '-ml-2'
                        ])
                        ->firstDayOfWeek(config('timex.week.start')),
                    TimePicker::make('startTime')
                        ->withoutSeconds()
                        ->disableLabel()
                        ->required()
                        ->default(now()->setMinutes(0)->addHour())
                        ->reactive()
                        ->extraAttributes([
                            'class' => '-ml-2'
                        ])
                        ->afterStateUpdated(function ($set,$state){
                            $set('endTime',Carbon::parse($state)->addMinutes(30));
                        })
                        ->disabled(function ($get){
                            return $get('isAllDay');
                        }),
                    DatePicker::make('end')
                        ->inlineLabel()
                        ->columnSpan(2)
                        ->default(today())
                        ->minDate(today())
                        ->reactive()
                        ->extraAttributes([
                            'class' => '-ml-2'
                        ])
                        ->firstDayOfWeek(config('timex.week.start')),
                    TimePicker::make('endTime')
                        ->withoutSeconds()
                        ->disableLabel()
                        ->reactive()
                        ->extraAttributes([
                            'class' => '-ml-2'
                        ])
                        ->default(now()->setMinutes(0)->addHour()->addMinutes(30))
                        ->disabled(function ($get){
                            return $get('isAllDay');
                        }),
                ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('subject'),
                TextColumn::make('body')->wrap()->limit(100),
                TextColumn::make('start')->date()
                    ->description(fn($record) => $record->startTime),
                TextColumn::make('end')->date()
                    ->description(fn($record)=> $record->endTime),
                BadgeColumn::make('category')
                    ->enum(config('timex.categories.labels'))
                    ->colors(config('timex.categories.colors'))
            ])->defaultSort('start');
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [];
    }

}

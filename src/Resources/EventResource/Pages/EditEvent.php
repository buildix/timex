<?php

namespace Buildix\Timex\Resources\EventResource\Pages;

use Carbon\Carbon;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Pages\Actions\DeleteAction;
use Filament\Resources\Form;
use Filament\Resources\Pages\EditRecord;
use Buildix\Timex\Resources\EventResource;

class EditEvent extends EditRecord
{
    protected static string $resource = EventResource::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)->schema([
                    Card::make([
                        TextInput::make('subject')
                            ->label(__('timex::timex.event.subject'))
                        ->required(),
                        RichEditor::make('body')
                        ->label(__('timex::timex.event.body'))
                    ])->columnSpan(2),
                    Card::make([
                        Grid::make(3)->schema([
                            Toggle::make('isAllDay')
                                ->label(__('timex::timex.event.allDay'))
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
                                ->label(__('timex::timex.event.start'))
                                ->inlineLabel()
                                ->columnSpan(2)
                                ->default(today())
                                ->minDate(today())
                                ->firstDayOfWeek(config('timex.week.start')),
                            TimePicker::make('startTime')
                                ->withoutSeconds()
                                ->disableLabel()
                                ->default(now()->setMinutes(0)->addHour())
                                ->reactive()
                                ->afterStateUpdated(function ($set,$state){
                                    $set('endTime',Carbon::parse($state)->addMinutes(30));
                                })
                                ->disabled(function ($get){
                                    return $get('isAllDay');
                                }),
                            DatePicker::make('end')
                                ->label(__('timex::timex.event.end'))
                                ->inlineLabel()
                                ->columnSpan(2)
                                ->default(today())
                                ->minDate(today())
                                ->firstDayOfWeek(config('timex.week.start')),
                            TimePicker::make('endTime')
                                ->withoutSeconds()
                                ->disableLabel()
                                ->reactive()
                                ->default(now()->setMinutes(0)->addHour()->addMinutes(30))
                                ->disabled(function ($get){
                                    return $get('isAllDay');
                                }),
                            Select::make('category')
                                ->label(__('timex::timex.event.category'))
                                ->columnSpanFull()
                                ->options(config('timex.categories.labels'))
                        ])
                    ])->columnSpan(1)
                ]),
            ]);
    }

    protected function getActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

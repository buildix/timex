<?php

namespace Buildix\Timex\Calendar;

use Buildix\Timex\Traits\TimexTrait;
use Carbon\Carbon;
use Closure;
use Filament\Pages\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Livewire\Component;

class EventList extends Component implements HasTable
{
    use InteractsWithTable;
    use TimexTrait;
    protected static string $model;
    protected static string $recource;
    protected $end;
    protected $start;
//      WIP
//    protected $listeners = [
//        'onTodayClick' => 'onTodayClick',
//        'onPrevClick' => 'onPrevClick',
//        'onNextClick' => 'onNextClick'
//    ];

    public function boot()
    {
        $this->start = Carbon::create($this->today);
        $this->end = Carbon::create($this->today)->endOfMonth();
    }

    public function onTodayClick()
    {
        $this->today = Carbon::today();
        $this->start = Carbon::create($this->today);
        $this->end = Carbon::create($this->today)->endOfMonth();
    }

    public function onPrevClick()
    {
        $this->today = $this->today->subMonth();
        $this->start = Carbon::create($this->today)->firstOfMonth();
        $this->end = Carbon::create($this->today)->endOfMonth();
    }

    public function onNextClick()
    {
        $this->today = $this->today->addMonth();
        $this->start = Carbon::create($this->today)->firstOfMonth();
        $this->end = Carbon::create($this->today)->endOfMonth();
    }

    protected static function getEventModel(): string
    {
        return static::$model = config('timex.models.event');
    }

    protected static function getEventResource(): string
    {
        return static::$recource = config('timex.resources.event');
    }

    protected function getTableQuery(): Builder|Relation
    {
        return self::getEventModel()::whereBetween('start', [$this->start, $this->end]);
    }

    public function render()
    {
        return view('timex::calendar.event-list');
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('subject')->label(__('timex::timex.event.subject'))
                ->description(function ($record){
                    return __('timex::timex.event-list.author',['name' => self::getUserModel()::find($record->organizer)->getAttribute(self::getUserModelColumn('name'))]);
                })->wrap(),
            TextColumn::make('start')->date()->description(function ($record){
                return __('timex::timex.event-list.start',['start' => Carbon::create($record->startTime)->format('G:i')]);
            })->label(__('timex::timex.event.start')),
            TextColumn::make('end')->date()->description(function ($record){
                return __('timex::timex.event-list.end',['end' => Carbon::create($record->endTime)->format('G:i')]);
            })->label(__('timex::timex.event.end')),
        ];
    }

    protected function getTableRecordUrlUsing(): ?Closure
    {
        return fn (Model $record): string => $this->getEventResource()::getUrl('edit', ['record' => $record]);
    }


}

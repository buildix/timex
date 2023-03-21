<?php

namespace Buildix\Timex\Calendar;

use Buildix\Timex\Events\InteractWithEvents;
use Buildix\Timex\Pages\Timex;
use Buildix\Timex\Traits\TimexTrait;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Livewire\Component;

class Month extends Component
{
    use TimexTrait;

    public $weeks;
    public $monthName;
    public $currYear;
    public $currMonth;
    public $dayLabels;
    public $weekDays;
    public $shouldRender = true;

    protected $listeners = [
        'onEventChanged' => 'onEventChanged',
        'modelUpdated' => 'loaded',
        'onTodayClick' => 'onTodayClick',
        'onPrevClick' => 'onPreviousMonthClick',
        'onNextClick' => 'onNextMonthClick',
        'onNextYearClick' => 'onNextYearClick',
        'onPreviousYearClick' => 'onPreviousYearClick',
        'onMonthDropDownClick' => 'onMonthDropDownClick',
    ];


    protected function setCalendar(): void
    {
        $this->setStartOfMonth();
        $this->setEndOfMonth();

        $this->currMonth = collect([]);
        while ($this->getStartOfMonth() <= $this->getEndOfMonth()){
            $this->currMonth->push([
                'id' => $this->startOfMonth->timestamp,
                'group' => "{$this->id}-{$this->startOfMonth->dayOfWeek}",
                'dayOfWeek' => $this->startOfMonth->dayOfWeek,
                'day' => $this->startOfMonth->day,
                'timestamp' => $this->startOfMonth->timestamp,
            ]);
            $this->startOfMonth->addDay();
        }

        $this->setDayLabels();

    }

    public function setDayLabels(): void
    {
        $this->dayLabels = collect([]);
        $dayOne = 0;
        foreach($this->currMonth as $weekOfDay ){
            $this->dayLabels->push([
                'dayOfWeek' => Carbon::createFromTimestamp($weekOfDay['id'])->dayOfWeek,
                'dayName' => match (config('timex.dayName')){
                        'dayName' => Carbon::createFromTimestamp($weekOfDay['id'])->dayName,
                        'shortDayName' => Carbon::createFromTimestamp($weekOfDay['id'])->shortDayName,
                        default => Carbon::createFromTimestamp($weekOfDay['id'])->minDayName,

                }
            ]);
            if(++$dayOne > 6) break;
        }
    }

    public function getDays(): array
    {
        $weekDays = $this->dayLabels;
        $currMonthDays = $this->currMonth;
        $weekDays = $weekDays
            ->map(function ($month) use ($currMonthDays) {
                $month['group'] = uuid_create();
                $month['dayName'] = $month['dayName'];
                $month['days'] = $currMonthDays
                    ->filter(function ($currMonthDays) use ($month) {
                        return $this->dayInWeekDay($currMonthDays, $month);
                    });
                return $month;
            });
        return [
            'weekDays' => $weekDays,
            'fullDays' => $currMonthDays
        ];
    }


    public function boot()
    {
        $this->setCalendar();
    }

    public function mount()
    {
        $this->monthName = $this->getMonthName(today());
    }

    public function render()
    {
        return view('timex::calendar.month');
    }

    public function onPreviousMonthClick()
    {
        $this->today = $this->today->subMonth();
        $this->monthName = $this->getMonthName($this->today);
        $this->setCalendar();
        $this->loaded();
        $this->emitUp('monthNameChanged',$this->today,$this->today->year);
    }

    public function onNextMonthClick()
    {
        $this->today = $this->today->addMonth();
        $this->monthName = $this->getMonthName($this->today);
        $this->setCalendar();
        $this->loaded();
        $this->emitUp('monthNameChanged',$this->today,$this->today->year);
    }

    public function onNextYearClick()
    {
        $this->today = $this->today->addYear();
        $this->monthName = $this->getMonthName($this->today);
        $this->setCalendar();
        $this->loaded();
        $this->emitUp('monthNameChanged',$this->today,$this->today->year);
    }

    public function onPreviousYearClick()
    {
        $this->today = $this->today->subYear();
        $this->monthName = $this->getMonthName($this->today);
        $this->setCalendar();
        $this->loaded();
        $this->emitUp('monthNameChanged',$this->today,$this->today->year);
    }

    public function onTodayClick()
    {
        $this->today = Carbon::today();
        $this->monthName = $this->getMonthName($this->today);
        $this->setCalendar();
        $this->loaded();
        $this->emitUp('monthNameChanged',$this->today,$this->today->year);
    }

    public function onMonthDropDownClick($month)
    {
        $this->today = Carbon::createFromTimestamp($month);
        $this->monthName = $this->getMonthName($this->today);
        $this->setCalendar();
        $this->loaded();
        $this->emitUp('monthNameChanged',$this->today,$this->today->year);
    }

    public function setStartOfMonth()
    {
        $this->startOfMonth = Carbon::create($this->today)->firstOfMonth()->startOfWeek($this->getStartOfWeek());
    }

    public function setEndOfMonth()
    {
        $this->endOfMonth = Carbon::create($this->today)->lastOfMonth()->endOfWeek($this->getEndOfWeek());
    }


    public function getStartOfMonth(): Carbon
    {
        return $this->startOfMonth;
    }

    public function getEndOfMonth(): Carbon
    {
        return $this->endOfMonth;
    }

    protected function dayInWeekDay($day, $weekDay)
    {
        return $day['dayOfWeek'] === $weekDay['dayOfWeek'];
    }

    public function loaded(){

        $this->dispatchBrowserEvent('monthLoaded',$this->getDays());
        $this->emitUp('monthNameChanged',$this->today,$this->today->year);
    }
    public function onEventChanged($eventID, $toDate)
    {
        $this->emitUp('eventUpdated',['id' => $eventID,'toDate' => $toDate]);
        $this->shouldSkipRender = true;
    }

    public function getMonthName($date){

        return $date->monthName.' '.$date->year;

    }




}

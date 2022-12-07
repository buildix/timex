<?php

namespace Buildix\Timex\Calendar;

use Buildix\Timex\Pages\Timex;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Livewire\Component;

class Day extends Component
{
    public $day;
    public $timestamp;
    public $first;
    public $last;
    public $events;
    public bool $isCurrentDay;
    public bool $isCurrentMonthDay;
    public bool $isWeekend;
    public $firstDayOfMonth;
    public bool $isFirstOfMonth;



    public function mount()
    {
        $this->events = $this->getEvents($this->timestamp);

        $this->isCurrentDay = \Carbon\Carbon::createFromTimestamp($this->timestamp)->isCurrentDay();
        $this->isCurrentMonthDay = \Carbon\Carbon::createFromTimestamp($this->timestamp)->isCurrentMonth();
        $this->isWeekend = \Carbon\Carbon::createFromTimestamp($this->timestamp)->isWeekend();
        $this->firstDayOfMonth = \Carbon\Carbon::createFromTimestamp($this->timestamp)->firstOfMonth()->timestamp;
        $this->isFirstOfMonth = $this->timestamp == $this->firstDayOfMonth;
    }


    public function getEvents($timespamp): Collection
    {
        $events = collect(Timex::getEvents())
            ->sortBy(function ($event){
                        $event->startTime;
        });
        return collect($events)->filter(function ($events) use ($timespamp){
            return $this->eventInDay($events->start,$timespamp);

        });
    }

    public function render()
    {
        return view('timex::calendar.day');
    }

    protected function eventInDay($event,$timespamp)
    {
        return $event == $timespamp;
    }


}

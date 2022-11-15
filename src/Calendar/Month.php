<?php

namespace Buildix\Timex\Calendar;

use Buildix\Timex\Traits\TimexTrait;
use Carbon\Carbon;
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
                'dayName' => Carbon::createFromTimestamp($weekOfDay['id'])->shortDayName,
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
                $month['dayName'] = $month['dayName'];
                $month['days'] = $currMonthDays
                    ->filter(function ($currMonthDays) use ($month) {
                        return $this->dayInWeekDay($currMonthDays, $month);
                    });
                return $month;
            });

        return [
            'weekDays' => $weekDays,
        ];
    }


    public function boot()
    {
        $this->setCalendar();

    }

    public function mount()
    {
        $this->monthName = today()->monthName;
        $this->dayLabels = $this->dayLabels;
        $this->currMonth = $this->currMonth;

    }

    public function render()
    {
        return view('timex::calendar.month');
    }

    public function onPreviousMonthClick()
    {
        $this->today = $this->today->subMonth();
        $this->monthName = $this->today->monthName;
        $this->setCalendar();
    }

    public function onNextMonthClick()
    {
        $this->today = $this->today->addMonth();
        $this->monthName = $this->today->monthName;
        $this->setCalendar();
    }

    public function onTodayClick()
    {
        $this->today = Carbon::today();
        $this->monthName = $this->today->monthName;
        $this->setCalendar();
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
}

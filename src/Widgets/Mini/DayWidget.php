<?php

namespace Buildix\Timex\Widgets\Mini;

use Livewire\Component;

class DayWidget extends Component
{
    public $monthName;
    public $day;
    public $dayName;

    public function mount()
    {
        $this->monthName = today()->shortMonthName;
        $this->day = today()->day;
        $this->dayName = today()->shortDayName;
    }

    public function render()
    {
        return view('timex::widgets.mini.day-widget');
    }
}

<?php

namespace Buildix\Timex\Widgets\Mini;

use Buildix\Timex\Traits\TimexTrait;
use Livewire\Component;

class DayWidget extends Component
{
    use TimexTrait;
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

    public function openCalendar()
    {
        return \Redirect::to(config('FILAMENT_PATH').'/'.$this->getPageClass()::getSlug());
    }
}

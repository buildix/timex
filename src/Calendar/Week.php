<?php

namespace Buildix\Timex\Calendar;

use Livewire\Component;

class Week extends Component
{
    public $name;
    public $dayOfWeek;
    public $days;
    public $last;

    public function render()
    {
        return view('timex::calendar.week');
    }
}

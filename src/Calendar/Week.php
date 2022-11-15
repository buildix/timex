<?php

namespace Buildix\Timex\Calendar;

use Livewire\Component;

class Week extends Component
{
    public $name;
    public $dayOfWeek;
    public $days;
    public $last;

    public function mount()
    {
        $this->name = $this->name;
        $this->dayOfWeek = $this->dayOfWeek;
        $this->days = $this->days;
        $this->last = $this->last;
    }
    public function render()
    {
        return view('timex::calendar.week');
    }
}

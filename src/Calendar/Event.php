<?php

namespace Buildix\Timex\Calendar;

use Livewire\Component;

class Event extends Component
{
    public $subject;
    public $body;
    public $start;
    public $startTime;
    public $eventID;
    public $color;
    public $icon;
    public $category;

    public function render()
    {
        return view('timex::calendar.event');
    }
}

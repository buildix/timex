<?php

namespace Buildix\Timex\Calendar;

use Livewire\Component;

class Event extends Component
{
    public $subject;
    public $body;
    public $start;
    public $eventID;
    public $color;
    public $icon;
    
    public function render()
    {
        return view('timex::calendar.event');
    }
}

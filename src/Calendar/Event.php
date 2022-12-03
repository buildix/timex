<?php

namespace Buildix\Timex\Calendar;

use Livewire\Component;

class Event extends Component
{

    public $body;
    public $category;
    public $color;
    public $eventID;
    public $icon;
    public $isAllDay;
    public $isWidgetEvent = false;
    public $organizer;
    public $start;
    public $startTime;
    public $subject;


    public function render()
    {
        return view('timex::calendar.event');
    }
}

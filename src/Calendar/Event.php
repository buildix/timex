<?php

namespace Buildix\Timex\Calendar;

use Livewire\Component;

class Event extends Component
{
    public $subject;
    public $body;
    public $start;
    public $eventID;

    public function mount()
    {
        $this->subject = $this->subject;
        $this->body = $this->body;
        $this->start = $this->start;
        $this->eventID = $this->eventID;
    }
    public function render()
    {
        return view('timex::calendar.event');
    }
}

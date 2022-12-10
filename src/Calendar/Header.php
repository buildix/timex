<?php

namespace Buildix\Timex\Calendar;

use Livewire\Component;

class Header extends Component
{
    public $monthName;

    public function render()
    {
        return view('timex::header.header');
    }
}

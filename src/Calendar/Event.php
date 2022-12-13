<?php

namespace Buildix\Timex\Calendar;

use Buildix\Timex\Traits\TimexTrait;
use Livewire\Component;

class Event extends Component
{
    use TimexTrait;

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
    public bool $isMyEvent;
    public bool $isModelEnabled;
    public bool $isInPast;

    public function mount()
    {
        $this->isMyEvent = $this->organizer == \Auth::id() ? true : false;
        $this->isModelEnabled = self::isCategoryModelEnabled() && \Str::isUuid($this->category) ? true : false;
        $model = $this->isModelEnabled ? $this->getModelData() : null;
        if ($this->isModelEnabled){
            $this->icon = $model[self::getCategoryModelColumn('icon')];
            $this->color = $model[self::getCategoryModelColumn('color')];

        }elseif (!$this->isModelEnabled && \Str::isUuid($this->category)){
            $this->icon = "";
            $this->color = "primary";
        }else{
            $this->icon = config('timex.categories.icons.'.$this->category);
            $this->color = config('timex.categories.colors.'.$this->color);
        }
        
        $eventStart = \Carbon\Carbon::createFromTimestamp($this->start)->setHours(23);
        $this->isInPast = $eventStart->isPast();

    }

    public function getModelData()
    {
        return $model = self::getCategoryModel()::query()->find($this->category)->getAttributes();
    }


    public function render()
    {
        return view('timex::calendar.event');
    }
}

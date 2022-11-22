<?php

namespace Buildix\Timex\Widgets\Mini;

use Buildix\Timex\Events\EventItem;
use Buildix\Timex\Events\InteractWithEvents;
use Buildix\Timex\Pages\Timex;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Collection;

class EventWidget extends Component
{
    use InteractWithEvents;

    public $events;

    protected $listeners = [
        'updateWidget' => 'updateWidget'
    ];

    public function updateWidget()
    {
        $this->reset('events');
        $this->events = self::getEvents();
    }

    public function mount()
    {
        $this->events = self::getEvents();
    }

    public static function getEvents(): Collection
    {
        $events = self::getModel()::orderBy('startTime')->get()
            ->map(function ($event){
                return EventItem::make($event->id)
                    ->subject($event->subject)
                    ->body($event->body)
                    ->color($event->category)
                    ->category($event->category)
                    ->start(Carbon::create($event->start))
                    ->startTime($event->startTime)
                    ->end(Carbon::create($event->end));
            })->toArray();

        return collect($events)->filter(function ($event){
            return Carbon::createFromTimestamp($event->start) == today() && $event->startTime > now()->isoFormat('H:mm:ss');
        });

    }

    public function render()
    {
        if (count($this->events) == 0){
            return view('timex::widgets.mini.event-widget-empty');
        }else{
            return view('timex::widgets.mini.event-widget');
        }
    }

}

<?php

namespace Buildix\Timex\Events;

use Carbon\Carbon;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Concerns\UsesResourceForm;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Fluent;
use Mikrosmile\FilamentCalendar\Models\Event;
use Mikrosmile\FilamentCalendar\Resources\EventResource;

trait InteractWithEvents
{
    use InteractsWithForms;
    use UsesResourceForm;
    public $editEventState = [];
    protected $eventModal;
    protected static string $resource;
    protected static string $model;

//    public function onEventClick($eventID)
//    {
//        $event = new Fluent(Event::find($eventID)->getAttributes());
//        $this->editEventState = $event->toArray();
//        $this->form
//        ->schema($this->getResourceForm(2)->getSchema())
//        ->statePath("editEventState");
//        $this->dispatchBrowserEvent('open-modal', ['id' => 'timex--event-modal']);
//    }

    public function onEventSubmit()
    {

    }


    public static function getResource(): string
    {
        return static::$resource = config('timex.resources.event');
    }

    protected function getFormModel(): Model|string|null
    {
        return static::$model = config('timex.models.event');
    }

    public function eventUpdated($data)
    {
        $event = Event::find($data['id']);
        $event->update([
            'start' => Carbon::createFromTimestamp($data['toDate'])
        ]);
        $this->emit('modelUpdated',['id' => $this->id]);
    }

//    protected function getEventForm(): array
//    {
//        return [
//            'eventForm' => $this->makeForm()
//                ->schema([
//                    TextInput::make('subject')
//                ])
//                ->statePath('editEventState'),
//        ];
//    }

}

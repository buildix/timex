<?php

namespace Buildix\Timex\Traits;

use Carbon\Carbon;
use Filament\Facades\Filament;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Fluent;
use Mikrosmile\FilamentCalendar\Models\Event;

/**
 * @TODO - fix translations
 * @property \Filament\Forms\ComponentContainer $form
 */

trait InteractsWithForm
{
    use InteractsWithForms;

    protected static ?string $eventResource;

    public function onEventClick($eventID)
    {
        $event = new Fluent(Event::find($eventID)->getAttributes());
        $icon = Carbon::create($event->start)->day;
//        $this->getFormSchema();

        Notification::make()
            ->title($event->subject)
            ->icon('timex-day-'.$icon)->iconColor('primary')
            ->body($event->body." ".$event->start)
            ->send();
    }

    public function __construct()
    {
        static::$eventResource = config('timex.resources.event');
    }

    protected function getFormStatePath(): string
    {
        return 'eventData';
    }

    public function getFormSchema(): array
    {
        return [
            'viewEvent' => $this->makeForm()
            ->schema([

            ])
            ->statePath($this->getFormStatePath())
        ];
    }


}

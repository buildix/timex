<?php

namespace Buildix\Timex\Pages;

use Buildix\Timex\Calendar\Month;
use Buildix\Timex\Events\EventItem;
use Buildix\Timex\Events\InteractWithEvents;
use Buildix\Timex\Traits\TimexTrait;
use Carbon\Carbon;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Resources\Form;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Fluent;
use Mikrosmile\FilamentCalendar\Models\Event;

class Timex extends Page
{
    use TimexTrait;
    protected static string $view = "timex::layout.page";
    protected static ?string $slug = "timex";
    protected static ?string $navigationIcon = "timex-timex";
    protected $listeners = ['eventUpdated','onEventClick'];

    protected static function getNavigationLabel(): string
    {
        return Carbon::today()->isoFormat('dddd, D MMM');
    }

    protected function getHeading(): string|Htmlable
    {
        return "";
    }

    protected function getTitle(): string
    {
        return Carbon::today()->isoFormat('dddd, D MMM');
    }

    public static function getEvents(): array
    {
        return Event::all()
            ->map(function (Event $event){
                return EventItem::make($event->id)
                    ->subject($event->subject)
                    ->color('success')
                    ->icon('heroicon-o-cake')
                    ->start(Carbon::create($event->start))
                    ->end(Carbon::create($event->end));
            })->toArray();
//        return [
//            EventItem::make(uuid_create())
//            ->start(Carbon::today())
//            ->end(Carbon::today())
//            ->subject('Meeting subject')
//            ->body('Meeting body'),
//
//            EventItem::make(uuid_create())
//                ->start(Carbon::today())
//                ->end(Carbon::today())
//                ->subject('Meeting subject 3')
//                ->body('Meeting body 3')
//                ->color('success'),
//
//            EventItem::make(uuid_create())
//                ->start(Carbon::today())
//                ->end(Carbon::today())
//                ->subject('Meeting subject 4')
//                ->body('Meeting body 4')
//                ->color('danger'),
//
//            EventItem::make(uuid_create())
//                ->start(Carbon::today())
//                ->end(Carbon::today())
//                ->subject('Meeting subject 5')
//                ->body('Meeting body 5')
//                ->color('warning'),
//            EventItem::make(uuid_create())
//                ->start(Carbon::today()->subMonth()->subDay())
//                ->end(Carbon::today()->subMonth()->subDay())
//                ->subject('Meeting subject 6')
//                ->body('Meeting body 6')
//                ->color('success'),
//            EventItem::make(uuid_create())
//                ->start(Carbon::today()->subMonth()->subDays(2))
//                ->end(Carbon::today()->subMonth()->subDays(2))
//                ->subject('Meeting subject 7')
//                ->body('Meeting body 7')
//                ->color('success'),
//            EventItem::make(uuid_create())
//                ->start(Carbon::today()->addMonths(2)->addDays(3))
//                ->end(Carbon::today()->addMonths(2)->addDays(3))
//                ->subject('Meeting subject 8')
//                ->body('Meeting body 8')
//                ->color('success'),
//
//            EventItem::make(uuid_create())
//            ->start(Carbon::tomorrow())
//            ->end(Carbon::tomorrow())
//            ->subject('Meeting subject 2')
//            ->body('Meeting body 2')
//            ->color('secondary'),
//
//            EventItem::make(uuid_create())
//            ->start(Carbon::today()->addDays(20))
//            ->end(Carbon::today()->addDays(20))
//            ->subject('Meeting subject 3')
//            ->color('danger')
//        ];
    }

    public function eventUpdated($data)
    {
        $event = Event::find($data['id']);
        $event->update([
            'start' => Carbon::createFromTimestamp($data['toDate'])
        ]);
        $this->emit('modelUpdated',['id' => $this->id]);
    }

    public function onEventClick($eventID)
    {
        $event = new Fluent(Event::find($eventID)->getAttributes());
        $icon = Carbon::create($event->start)->day;

        Notification::make()
            ->title($event->subject)
            ->icon('timex-day-'.$icon)->iconColor('primary')
            ->body($event->body." ".$event->start)
            ->send();
    }

}

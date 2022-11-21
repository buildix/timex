<?php

namespace Buildix\Timex\Pages;

use Buildix\Timex\Calendar\Month;
use Buildix\Timex\Events\EventItem;
use Buildix\Timex\Events\InteractWithEvents;
use Buildix\Timex\Traits\TimexTrait;
use Carbon\Carbon;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Actions\Action;
use Filament\Pages\Actions\ActionGroup;
use Filament\Pages\Actions\CreateAction;
use Filament\Pages\Actions\DeleteAction;
use Filament\Pages\Page;
//use Filament\Resources\Form;
use Filament\Forms;
use Filament\Resources\Pages\Concerns\UsesResourceForm;
use Filament\Resources\Resource;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Fluent;
use Mikrosmile\FilamentCalendar\Models\Event;

class Timex extends Page
{
    use TimexTrait;
    use InteractWithEvents;
    use UsesResourceForm;

    protected static string $view = "timex::layout.page";
    protected static ?string $slug = "timex";
    protected static ?string $navigationIcon = "timex-timex";
    protected static ?string $eventResource;
    protected $listeners = ['eventUpdated','onEventClick','monthNameChanged'];
    protected static $eventData;
    protected static ?string $eventHeading = "Create event";
    public string $monthName = "";

    protected static function getNavigationLabel(): string
    {
        return Carbon::today()->isoFormat('dddd, D MMM');
    }


    protected function getHeading(): string|Htmlable
    {
        return " ";
    }

    protected function getBreadcrumbs(): array
    {
        return [
            Carbon::today()->isoFormat('dddd, D MMM')
        ];
    }

    public function monthNameChanged($data,$year)
    {
        if (today()->year != $year){
            $this->monthName = $data." ".$year;
        }else{
            $this->monthName = $data;
        }
    }

    public function __construct()
    {
        $this->monthName = today()->monthName;
    }

    protected function getActions(): array
    {
        return [
                Action::make('currMonth')
                    ->size('sm')
                    ->disabled()
                    ->color('secondary')
                    ->outlined()
                    ->label($this->monthName),
                Action::make('openCreateModal')
                    ->label('Create event')
                    ->icon('heroicon-o-plus')
                    ->size('sm')->outlined()->slideOver()
                    ->extraAttributes([
                        'class' => '-mr-2'
                    ])
                    ->form($this->getResourceForm(2)->getSchema())
                    ->mountUsing(fn (Forms\ComponentContainer $form) => $form->fill(self::$eventData))
                    ->modalHeading(self::$eventHeading)
                    ->modalWidth('xl')
                    ->action(function (array $data){
                        if ($data['id'] == null){
                            $this->getFormModel()::query()->create($data);
                            $this->emit('modelUpdated',['id' => $this->id]);
                        }else{
                            $this->getFormModel()::query()->find($data['id'])->update($data);
                            $this->emit('modelUpdated',['id' => $this->id]);
                        }
                }),
                Action::make('prev')
                    ->size('sm')
                    ->icon('heroicon-o-chevron-left')
                    ->extraAttributes(['class' => '-mr-2 -ml-1'])
                    ->outlined()->disableLabel()
                    ->action(function (){
                        $this->emit('onPrevClick');
//                        $this->getHeading();
                }),
                Action::make('today')
                    ->size('sm')
                    ->outlined()
                    ->extraAttributes(['class' => '-ml-1 -mr-1'])
                    ->label(fn() => \Carbon\Carbon::today()->format('d M'))
                    ->action(function (){
                        $this->emit('onTodayClick');
                }),
                Action::make('next')
                    ->size('sm')
                    ->icon('heroicon-o-chevron-right')
                    ->extraAttributes(['class' => '-ml-2'])
                    ->outlined()->disableLabel()
                    ->action(function (){
                        $this->emit('onNextClick');
                }),
        ];
    }

    public function test()
    {

    }

    protected function getTitle(): string
    {
        return Carbon::today()->isoFormat('dddd, D MMM');
    }

    public function getEventResource()
    {
        return static::$eventResource = config('timex.resources.event');
    }

    public static function getEvents(): array
    {
        return Event::orderBy('startTime')->get()
            ->map(function (Event $event){
                return EventItem::make($event->id)
                    ->subject($event->subject)
                    ->body($event->body)
                    ->color($event->categories)
                    ->category($event->categories)
                    ->icon('heroicon-o-cake')
                    ->start(Carbon::create($event->start))
                    ->startTime(Carbon::createFromTimeString($event->startTime))
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



    public function onEventClick($eventID)
    {
        $event = new Fluent(Event::find($eventID)->getAttributes());
        self::$eventData = $event->toArray();
        self::$eventHeading = "Edit event: ".$event->subject;
        $this->mountAction('openCreateModal');
    }

}

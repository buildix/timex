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
use Filament\Forms;
use Filament\Resources\Pages\Concerns\UsesResourceForm;
use Filament\Resources\Resource;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Fluent;
use Illuminate\Support\Str;
use function Filament\Support\get_model_label;

class Timex extends Page
{
    use TimexTrait;
    use InteractWithEvents;
    use UsesResourceForm;

    protected static string $view = "timex::layout.page";
    protected $listeners = ['eventUpdated','onEventClick','monthNameChanged'];
    protected static $eventData;
    public string $monthName = "";

    protected static function getNavigationLabel(): string
    {
        return config('timex.pages.label.navigation');
    }

    protected function getTitle(): string
    {
        return config('timex.pages.label.title');
    }

    protected function getBreadcrumbs(): array
    {
        return [
            config('timex.pages.label.breadcrumbs')
        ];
    }

    protected static function getNavigationGroup(): ?string
    {
        return config('timex.pages.group');
    }

    protected static function getNavigationIcon(): string
    {
        return config('timex.pages.icon.static') ? config('timex.pages.icon.timex') : config('timex.pages.icon.day');
    }

    public static function getSlug(): string
    {
        return config('timex.pages.slug');
    }

    protected static function shouldRegisterNavigation(): bool
    {
        return config('timex.pages.shouldRegisterNavigation');
    }

    protected function getHeading(): string|Htmlable
    {
        return " ";
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
                    ->label(__('filament::resources/pages/create-record.title',
                            ['label' => \Str::headline(static::getResource()::getModelLabel())]))
                    ->icon(config('timex.pages.buttons.icons.createEvent'))
                    ->size('sm')
                    ->outlined(config('timex.pages.buttons.outlined'))
                    ->slideOver()
                    ->extraAttributes(['class' => '-mr-2'])
                    ->form($this->getResourceForm(2)->getSchema())
                    ->mountUsing(fn (Forms\ComponentContainer $form) => $form->fill(self::$eventData))
                    ->modalHeading(\Str::headline(static::getResource()::getModelLabel()))
                    ->modalWidth(config('timex.pages.modalWidth'))
                    ->action(fn(array $data) => $this->updateOrCreate($data))
                    ->extraModalActions([
                        Action::makeModalAction('delete')
                            ->color('danger')
                            ->action('deleteEvent')
                            ->cancel()
                    ]),
                Action::make('prev')
                    ->size('sm')
                    ->icon(config('timex.pages.buttons.icons.previousMonth'))
                    ->extraAttributes(['class' => '-mr-2 -ml-1'])
                    ->outlined(config('timex.pages.buttons.outlined'))
                    ->disableLabel()
                    ->action(fn() => $this->emit('onPrevClick')),
                Action::make('today')
                    ->size('sm')
                    ->outlined(config('timex.pages.buttons.outlined'))
                    ->extraAttributes(['class' => '-ml-1 -mr-1'])
                    ->label(config('timex.pages.buttons.today'))
                    ->action(fn() => $this->emit('onTodayClick')),
                Action::make('next')
                    ->size('sm')
                    ->icon(config('timex.pages.buttons.icons.nextMonth'))
                    ->extraAttributes(['class' => '-ml-2'])
                    ->outlined(config('timex.pages.buttons.outlined'))
                    ->disableLabel()
                    ->action(fn() => $this->emit('onNextClick')),
        ];
    }

    public static function getEvents(): array
    {
        return self::getModel()::orderBy('startTime')->get()
            ->map(function ($event){
                return EventItem::make($event->id)
                    ->subject($event->subject)
                    ->body($event->body)
                    ->color($event->category)
                    ->category($event->category)
                    ->start(Carbon::create($event->start))
                    ->startTime(Carbon::createFromTimeString($event->startTime))
                    ->end(Carbon::create($event->end));
            })->toArray();
    }


    public function setNullRecord()
    {
        $this->record = null;
    }

    public function updateOrCreate($data)
    {
        if ($data['organizer'] == null){
            $this->getModel()::query()->create([...$data,'organizer' => \Auth::id()]);
        }else{
            $this->getFormModel()::query()->find($this->getFormModel()->id)->update($data);
        }
        $this->dispatEventUpdates();
    }

    public function deleteEvent()
    {
        $this->getFormModel()->delete();
        $this->dispatEventUpdates();
    }

    public function dispatEventUpdates(): void
    {
        $this->emit('modelUpdated',['id' => $this->id]);
        $this->record = null;
    }

    public function onEventClick($eventID)
    {
        $this->record = $eventID;
        $event = $this->getFormModel()->getAttributes();
        self::$eventData = $event;
        $this->mountAction('openCreateModal');
    }

}

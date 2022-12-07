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
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Fluent;
use Illuminate\Support\Str;
use mysql_xdevapi\Collection;
use function Filament\Support\get_model_label;

class Timex extends Page
{
    use TimexTrait;
    use InteractWithEvents;
    use UsesResourceForm;

    protected static string $view = "timex::layout.page";
    protected $listeners = ['eventUpdated','onEventClick','monthNameChanged','onDayClick','onCreateClick'];
    protected static $eventData;
    public string $monthName = "";

    protected static function getNavigationLabel(): string
    {
        return config('timex.pages.label.navigation.static') ? trans('timex::timex.labels.navigation') : self::getDynamicLabel('navigation');
    }

    protected function getTitle(): string
    {
        return config('timex.pages.label.title.static') ? trans('timex::timex.labels.title') : self::getDynamicLabel('title');
    }

    protected function getBreadcrumbs(): array
    {
        return [
            config('timex.pages.label.breadcrumbs.static') ? trans('timex::timex.labels.breadcrumbs') : self::getDynamicLabel('breadcrumbs')
        ];
    }

    protected static function getNavigationGroup(): ?string
    {
        return config('timex.pages.group');
    }

    protected static function getNavigationSort(): ?int
    {
        return config('timex.pages.sort',0);
    }

    protected static function getNavigationIcon(): string
    {
        return config('timex.pages.icon.static') ? config('timex.pages.icon.timex') : config('timex.pages.icon.day').Carbon::today()->day;
    }

    public static function getSlug(): string
    {
        return config('timex.pages.slug');
    }

    protected static function shouldRegisterNavigation(): bool
    {
        if (!config('timex.pages.shouldRegisterNavigation')){
            return false;
        }
        if (config('timex.pages.enablePolicy',false) && \Gate::getPolicyFor(self::getModel()) && !\Gate::allows('viewAny',self::getModel())){
            return false;
        }

        return true;
    }

    protected function getHeading(): string|Htmlable
    {
        return " ";
    }

    public function monthNameChanged($data,$year)
    {
            $this->monthName = $data;
    }

    public function __construct()
    {
        $this->monthName = today()->monthName." ".today()->year;
    }

    protected function getActions(): array
    {
        return [
                Action::make('openCreateModal')
                    ->label(trans('filament::resources/pages/create-record.title',
                            ['label' => Str::lower(__('timex::timex.model.label'))]))
                    ->icon(config('timex.pages.buttons.icons.createEvent'))
                    ->size('sm')
                    ->outlined(config('timex.pages.buttons.outlined'))
                    ->slideOver()
                    ->extraAttributes(['class' => '-mr-2'])
                    ->form($this->getResourceForm(2)->getSchema())
                    ->modalHeading(trans('timex::timex.model.label'))
                    ->modalWidth(config('timex.pages.modalWidth'))
                    ->action(fn(array $data) => $this->updateOrCreate($data))
                    ->modalActions([
                        Action::makeModalAction('submit')
                            ->label(trans('timex::timex.modal.submit'))
                            ->color(config('timex.pages.buttons.modal.submit.color','primary'))
                            ->outlined(config('timex.pages.buttons.modal.submit.outlined',false))
                            ->icon(config('timex.pages.buttons.modal.submit.icon.name',''))
                            ->submit()
                            ->visible(function (){
                                return $this->mountedActionData['organizer'] == \Auth::id() ? true : ($this->mountedActionData['organizer'] != \Auth::id() ? $this->mountedActionData['organizer'] == null : true);
                            }),
                        Action::makeModalAction('delete')
                            ->label(trans('timex::timex.modal.delete'))
                            ->color(config('timex.pages.buttons.modal.delete.color','danger'))
                            ->outlined(config('timex.pages.buttons.modal.delete.outlined', false))
                            ->icon(config('timex.pages.buttons.modal.delete.icon.name',''))
                            ->action('deleteEvent')
                            ->cancel()
                            ->visible(function (){
                                return $this->mountedActionData['organizer'] == \Auth::id() ? true : ($this->mountedActionData['organizer'] != \Auth::id() ? false : true);
                            }),
                        Action::makeModalAction('cancel')
                            ->label(trans('timex::timex.modal.cancel'))
                            ->color(config('timex.pages.buttons.modal.cancel.color','secondary'))
                            ->outlined(config('timex.pages.buttons.modal.cancel.outlined',false))
                            ->icon(config('timex.pages.buttons.modal.cancel.icon.name',''))
                            ->cancel(),
                    ]),
        ];
    }

    public static function getEvents(): array
    {
        $events = self::getModel()::orderBy('startTime')->get()
            ->map(function ($event){
                return EventItem::make($event->id)
                    ->body($event->body)
                    ->category($event->category)
                    ->color($event->category)
                    ->end(Carbon::create($event->end))
                    ->isAllDay($event->isAllDay)
                    ->subject($event->subject)
                    ->organizer($event->organizer)
                    ->participants($event?->participants)
                    ->start(Carbon::create($event->start))
                    ->startTime($event->startTime);
            })->toArray();

        return collect($events)->filter(function ($event){
            return $event->organizer == \Auth::id() || in_array(\Auth::id(), $event?->participants ?? []);
        })->toArray();
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
        $this->emit('updateWidget',['id' => $this->id]);
    }

    public function onEventClick($eventID)
    {
        $this->record = $eventID;
        $event = $this->getFormModel()->getAttributes();
        $this->mountAction('openCreateModal');
        $this->getMountedActionForm()
            ->fill([
            ...$event,
            'participants' => self::getFormModel()?->participants
            ]);
        $this->getMountedActionForm()->disabled($this->getFormModel()->getAttribute('organizer') !== \Auth::id());
    }

    public function onDayClick($timestamp)
    {
        if (config('timex.isDayClickEnabled')){
            $this->mountAction('openCreateModal');
            $this->getMountedActionForm()
                ->fill([
                    'startTime' => Carbon::now()->setMinutes(0)->addHour(),
                    'endTime' => Carbon::now()->setMinutes(0)->addHour()->addMinutes(30),
                    'start' => Carbon::createFromTimestamp($timestamp),
                    'end' => Carbon::createFromTimestamp($timestamp)
                ]);
        }
    }

    public function onCreateClick()
    {
        $this->mountAction('openCreateModal');
        $this->getMountedActionForm()
            ->fill([
                'startTime' => Carbon::now()->setMinutes(0)->addHour(),
                'endTime' => Carbon::now()->setMinutes(0)->addHour()->addMinutes(30),
                'start' => Carbon::createFromTimestamp(today()->timestamp),
                'end' => Carbon::createFromTimestamp(today()->timestamp)
            ]);
    }

    protected function getHeader(): ?View
    {
        return \view('timex::calendar.header');
    }
}

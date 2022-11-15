<?php

namespace Buildix\Timex\Pages;

use Buildix\Timex\Events\EventItem;
use Carbon\Carbon;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class Timex extends Page
{
    protected static string $view = "timex::layout.page";
    protected static ?string $slug = "timex";
    protected static ?string $navigationIcon = "timex-timex";

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
        return [
            EventItem::make(uuid_create())
            ->start(Carbon::today())
            ->end(Carbon::today())
            ->subject('Meeting subject')
            ->body('Meeting body'),
            EventItem::make(uuid_create())
            ->start(Carbon::tomorrow())
            ->end(Carbon::tomorrow())
            ->subject('Meeting subject 2')
            ->body('Meeting body 2'),
            EventItem::make(uuid_create())
            ->start(Carbon::today()->addDays(20))
            ->end(Carbon::today()->addDays(20))
            ->subject('Meeting subject 3')
        ];
    }

}

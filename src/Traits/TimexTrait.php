<?php

namespace Buildix\Timex\Traits;

use Carbon\Carbon;

trait TimexTrait
{
    public Carbon $today;
    public $startOfWeek;
    public $endOfWeek;
    public Carbon $startOfMonth;
    public Carbon $endOfMonth;

    public function __construct()
    {
        $this->today = $this->getToday();
    }

    /**
     * @return Carbon
     */
    public function getToday(): Carbon
    {
        return Carbon::today();
    }

    public function getCurrMonth(?Carbon $currMonth): static
    {
        return $this->currMonth = $currMonth ? $currMonth : today()->month;
    }

    public function getStartOfWeek()
    {
        return $this->startOfWeek = config('timex.week.start');
    }

    public function getEndOfWeek()
    {
        return $this->endOfWeek = config('timex.week.end');;
    }

    public static function getPageClass()
    {
        return config('timex.pages.timex');
    }

    public static function getUserModel()
    {
        return config('timex.models.users.model');
    }

    public static function getEventTableName()
    {
        return config('timex.tables.event.name');
    }

    public static function getUserModelColumn($column)
    {
        return match ($column){
            'name' => config('timex.models.users.name'),
            'id' => config('timex.models.users.id')
        };
    }

    public static function getDynamicLabel(string $label)
    {
        $format = match ($label){
            'navigation' => config('timex.pages.label.navigation.format'),
            'breadcrumbs' => config('timex.pages.label.breadcrumbs.format'),
            'title' => config('timex.pages.label.title.format'),
            'today' => config('timex.pages.buttons.today.format'),
        };

        return Carbon::today()->isoFormat($format);
    }

    public static function getCategoryModel()
    {
        return config('timex.categories.model.class');
    }

    public static function getCategoryModelColumn(string $column)
    {
        return match ($column){
          'key' => config('timex.categories.model.key'),
          'value' => config('timex.categories.model.value'),
          'icon' => config('timex.categories.model.icon'),
          'color' => config('timex.categories.model.color')
        };
    }

    public static function isCategoryModelEnabled(): bool
    {
        return config('timex.categories.isModelEnabled');
    }

}

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


}

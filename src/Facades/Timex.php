<?php

namespace Buildix\Timex\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Buildix\Timex\Timex
 */
class Timex extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "timex";
    }
}

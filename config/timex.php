<?php

// config for Buildix/Timex
return [
    'prefix' => 'timex',
    "mini" => [
        'isMiniCalendarEnabled' => true,
        'isDayViewHidden' => false,
        'isNextMeetingViewHidden' => false,
    ],
    "week" => [
      'start' => \Carbon\Carbon::MONDAY,
      'end' =>  \Carbon\Carbon::SUNDAY
    ],

];

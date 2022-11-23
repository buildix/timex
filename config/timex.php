<?php

use Carbon\Carbon;

return [
    /*
    |--------------------------------------------------------------------------
    | TIMEX Icon set
    |--------------------------------------------------------------------------
    |
    | Don't change that prefix, otherwise icon set will not work.
    |
    */

    'prefix' => 'timex',

    /*
    |--------------------------------------------------------------------------
    | TIMEX Mini widget
    |--------------------------------------------------------------------------
    |
    | You can disable or enable individually widgets or entirely the whole view.
    |
    */

    'mini' => [
        'isMiniCalendarEnabled' => true,
        'isDayViewHidden' => false,
        'isNextMeetingViewHidden' => false,
        'noEventsTitle' => 'No upcoming events'
    ],

    /*
    |--------------------------------------------------------------------------
    | TIMEX Calendar configurations
    |--------------------------------------------------------------------------
    |
    | Change according to your locale.
    |
    */

    'week' => [
        'start' => \Carbon\Carbon::MONDAY,
        'end' =>  \Carbon\Carbon::SUNDAY
    ],

    'dayName' => 'minDayName', // minDayName or dayName or shortDayName

    /*
    |--------------------------------------------------------------------------
    | TIMEX Resources & Pages
    |--------------------------------------------------------------------------
    |
    | By default TIMEX out of box will work, just make sure you make migration.
    | But you can also make your own Model and Filament resource and update config accordingly
    |
    */

    'pages' => [
        'timex' => \Buildix\Timex\Pages\Timex::class,
        'slug' => 'timex',
        'group' => 'timex',
        'shouldRegisterNavigation' => true,
        'modalWidth' => 'xl',
        'icon' => [
            'static' => true,
            'timex' => 'timex-timex',
            'day' => 'timex-day-'
        ],
        'label' => [
            'navigation' => 'dddd, D MMM',
            'breadcrumbs' => 'dddd, D MMM',
            'title' => 'dddd, D MMM'
        ],
        'buttons' => [
            'today' => 'D MMM',
            'outlined' => true,
            'icons' => [
                'previousMonth' => 'heroicon-o-chevron-left',
                'nextMonth' => 'heroicon-o-chevron-right',
                'createEvent' => 'heroicon-o-plus'
            ],
        ],
    ],

    'resources' => [
        'event' => \Buildix\Timex\Resources\EventResource::class,
        'icon' => 'heroicon-o-calendar',
        'slug' => 'timex-events',
        'shouldRegisterNavigation' => true,
    ],
    'models' => [
        'event' => \Buildix\Timex\Models\Event::class,
        'label' => 'Event',
        'pluralLabel' => 'Events'
    ],

    /*
    |--------------------------------------------------------------------------
    | TIMEX Event categories
    |--------------------------------------------------------------------------
    |
    | Categories names are used to define color.
    | Each represents default tailwind colors.
    | You may change as you wish, just make sure your color have -500 / -600 and etc variants
    |
    */

    'categories' => [
            'labels' => [
                'primary' => 'Primary category',
                'secondary' => 'Secondary category',
                'danger' => 'Danger category',
                'success' => 'Success category',
            ],
            'icons' => [
                'primary' => 'heroicon-o-clipboard',
                'secondary' => 'heroicon-o-bookmark',
                'danger' => 'heroicon-o-flag',
                'success' => 'heroicon-o-badge-check',
            ],
            'colors' => [
                'primary' => 'primary',
                'secondary' => 'secondary',
                'danger' => 'danger',
                'success' => 'success',
            ],
    ],

];

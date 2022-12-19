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
        'start' => Carbon::MONDAY,
        'end' =>  Carbon::SUNDAY
    ],
    'isDayClickEnabled' => true,

    'dayName' => 'minDayName', // minDayName or dayName or shortDayName

    'dropDownCols' => 3,

    'isPastCreationEnabled' => false,

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
        'sort' => 0,
        'shouldRegisterNavigation' => true,
        'enablePolicy' => false,
        'modalWidth' => 'xl',
        'icon' => [
            'static' => true,
            'timex' => 'timex-timex',
            'day' => 'timex-day-'
        ],
        'label' => [
            'navigation' => [
                'static' => false,
                'format' => 'dddd, D MMM',
            ],
            'breadcrumbs' => [
                'static' => false,
                'format' => 'dddd, D MMM',
            ],
            'title' => [
              'static' => false,
              'format' => 'dddd, D MMM',
            ],
        ],
        'buttons' => [
            'hideYearNavigation' => false,
            'today' => [
                'static' => false,
                'format' => 'D MMM'
            ],
            'outlined' => true,
            'icons' => [
                'previousYear' => 'heroicon-o-chevron-double-left',
                'nextYear' => 'heroicon-o-chevron-double-right',
                'previousMonth' => 'heroicon-o-chevron-left',
                'nextMonth' => 'heroicon-o-chevron-right',
                'createEvent' => 'heroicon-o-plus'
            ],
            'modal' => [
                'submit' => [
                    'outlined' => false,
                    'color' => 'primary',
                    'icon' => [
                        'enabled' => true,
                        'name' => 'heroicon-o-save'
                    ],
                ],
                'cancel' => [
                    'outlined' => false,
                    'color' => 'secondary',
                    'icon' => [
                        'enabled' => true,
                        'name' => 'heroicon-o-x-circle'
                    ],
                ],
                'delete' => [
                    'outlined' => false,
                    'color' => 'danger',
                    'icon' => [
                        'enabled' => true,
                        'name' => 'heroicon-o-trash'
                    ],
                ],
                'edit' => [
                    'outlined' => false,
                    'color' => 'primary',
                    'icon' => [
                        'enabled' => true,
                        'name' => 'heroicon-o-pencil-alt'
                    ],
                ],
                'view' => [
                    'time' => 'heroicon-o-clock',
                    'category' => 'heroicon-o-tag',
                    'body' => 'heroicon-o-annotation',
                    'participants' => 'heroicon-o-user-group',
                ],
            ],
        ],
    ],

    'resources' => [
        'event' => \Buildix\Timex\Resources\EventResource::class,
        'sort' => 1,
        'icon' => 'heroicon-o-calendar',
        'slug' => 'timex-events',
        'shouldRegisterNavigation' => true,
        'isStartEndHidden' => false,
    ],
    'models' => [
        'event' => \Buildix\Timex\Models\Event::class,
        'users' => [
            'model' => \App\Models\User::class,
            'name' => 'name',
            'id' => 'id',
        ],
    ],
    'tables' => [
        'event' => [
            'name' => 'timex_events',
        ],
        'category' => [
            'name' => 'timex_categories',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | TIMEX Event categories
    |--------------------------------------------------------------------------
    |
    | Categories names are used to define colors & icons.
    | Each represents default tailwind colors.
    | You may change as you wish, just make sure your color have -500 / -600 and etc variants
    | You may also go for a custom Category model to define your labels, colors and icons
    |
    */

    'categories' => [
            'isModelEnabled' => false,
    /*
    |--------------------------------------------------------------------------
    | Category Model
    |--------------------------------------------------------------------------
    |
    | You can define your custom Category model.
    | Minimum and default columns in your DB should be: id, value, icon, color.
    |
    |
    */
            'model' => [
                'class' => \Buildix\Timex\Models\Category::class, // \App\Models\Category::class
                'key' => 'id', // "id" is a DB column - you can change by any primary key
                'value' => 'value', // "value" is a DB column - it used for Select options and displays on Resource page
                'icon' => 'icon', // "icon" is a DB column - define here any heroicon- icon
                'color' => 'color', // "color" is a DB column - default tailwindcss colors names like: primary / secondary / danger
            ],
        /*
        |--------------------------------------------------------------------------
        | Default TiMEX Categories
        |--------------------------------------------------------------------------
        */
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

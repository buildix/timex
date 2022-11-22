<?php

namespace Buildix\Timex\Models;

use Buildix\Timex\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use Uuids;

    protected $guarded = [];

    protected $casts = [
        'start' => 'date',
        'end' => 'date',
        'isAllDay' => 'boolean',
    ];

    public function getTable()
    {
        return 'timex_events';
    }

    public function __construct(array $attributes = [])
    {
        $attributes['organizer'] = \Auth::id();

        parent::__construct($attributes);

    }
    


}

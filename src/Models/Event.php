<?php

namespace Buildix\Timex\Models;

use App\Models\User;
use Buildix\Timex\Traits\TimexTrait;
use Buildix\Timex\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\PermissionRegistrar;

class Event extends Model
{
    use Uuids;
    use TimexTrait;

    protected $guarded = [];

    protected $casts = [
        'start' => 'date',
        'end' => 'date',
        'isAllDay' => 'boolean',
        'participants' => 'array'
    ];

    public function getTable()
    {
        return config('timex.tables.event.name', parent::getTable());
    }

    public function __construct(array $attributes = [])
    {
        $attributes['organizer'] = \Auth::id();

        parent::__construct($attributes);

    }

    public function category()
    {
        return $this->hasOne(self::getCategoryModel());
    }

}

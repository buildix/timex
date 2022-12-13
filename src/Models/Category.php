<?php

namespace Buildix\Timex\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasUuids;

    protected $guarded = [];
    public $timestamps = false;

    public function getTable()
    {
        return config('timex.tables.category.name', "timex_categories");
    }
}

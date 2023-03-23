<?php

namespace Buildix\Timex\Resources\EventResource\Pages;

use Buildix\Timex\Events\InteractWithEvents;
use Buildix\Timex\Traits\TimexTrait;
use Closure;
use Filament\Pages\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Buildix\Timex\Resources\EventResource;

class ListEvents extends ListRecords
{
    use TimexTrait;
    protected static string $resource = EventResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected function getTableQuery(): Builder
    {
        if (in_array('participants', \Schema::getColumnListing(self::getEventTableName()))) {
            return parent::getTableQuery()
                ->where('organizer', '=', \Auth::id())
                ->orWhereRaw('JSON_CONTAINS(participants, \'"' . \Auth::id() . '"\')');
        } else {
            return parent::getTableQuery();
        }
    }

    public function mount()
    {
        self::setupSqlite();
    }

    private static function setupSqlite(): void
    {
        DB::connection()->getPdo()->sqliteCreateFunction('JSON_CONTAINS', function ($json, $val, $path = null) {
            $array = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

            $val = trim($val, '"');

            if ($path) {
                return $array[$path] == $val;
            }

            return in_array($val, $array, true);
        });
    }
}

<?php

namespace Buildix\Timex\Resources\EventResource\Pages;

use App\Models\User;
use Buildix\Timex\Traits\TimexTrait;
use Carbon\Carbon;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Pages\Actions\DeleteAction;
use Filament\Resources\Form;
use Filament\Resources\Pages\EditRecord;
use Buildix\Timex\Resources\EventResource;

class EditEvent extends EditRecord
{
    use TimexTrait;
    protected static string $resource = EventResource::class;

    public function form(Form $form): Form
    {
        return $form->schema(self::getResource()::getCreateEditForm());
    }

    protected function getActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

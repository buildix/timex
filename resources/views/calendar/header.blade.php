<div class="justify-between sm:items-center grid sm:flex gap-2">
    <div class="font-medium text-lg">
        {{$this->monthName}}
    </div>
    <div class="flex items-center gap-1">
        <x-filament-support::button
            wire:click="$emit('onPreviousYearClick')"
            @class([
            'hidden' => config('timex.pages.buttons.hideYearNavigation', false)
            ])
            :size="'sm'"
            :color="'secondary'"
            :dark-mode="true"
            :outlined="config('timex.pages.buttons.outlined')">
            <x-dynamic-component :component="config('timex.pages.buttons.icons.previousYear', 'heroicon-o-chevron-double-left')" class="h-4 w-4"/>
        </x-filament-support::button>
        <x-filament-support::button
            wire:click="$emit('onPrevClick')"
            :size="'sm'"
            :dark-mode="true"
            :outlined="config('timex.pages.buttons.outlined')">
            <x-dynamic-component :component="config('timex.pages.buttons.icons.previousMonth')" class="h-4 w-4"/>
        </x-filament-support::button>
        <x-filament-support::button
            wire:click="$emit('onTodayClick')"
            :size="'sm'"
            :dark-mode="true"
            :outlined="config('timex.pages.buttons.outlined')">
            {{config('timex.pages.buttons.today.static') ? trans('timex::timex.labels.today') : self::getDynamicLabel('today')}}
        </x-filament-support::button>
        <x-filament-support::button
            wire:click="$emit('onNextClick')"
            :size="'sm'"
            :dark-mode="true"
            :outlined="config('timex.pages.buttons.outlined')">
            <x-dynamic-component :component="config('timex.pages.buttons.icons.nextMonth')" class="h-4 w-4"/>
        </x-filament-support::button>
        <x-filament-support::button
            wire:click="$emit('onNextYearClick')"
            @class([
            'hidden' => config('timex.pages.buttons.hideYearNavigation', false)
            ])
            :size="'sm'"
            :color="'secondary'"
            :dark-mode="true"
            :outlined="config('timex.pages.buttons.outlined')">
            <x-dynamic-component :component="config('timex.pages.buttons.icons.nextYear','heroicon-o-chevron-double-right')" class="h-4 w-4"/>
        </x-filament-support::button>
        <span class="border border-gray-300 dark:border-gray-400 h-5 rounded ml-2 mr-2"></span>
        <x-filament-support::button
            wire:click="$emit('onCreateClick')"
            :icon="config('timex.pages.buttons.icons.createEvent')"
            :outlined="true"
            :dark-mode="true"
            :size="'sm'">
            {{trans('filament::resources/pages/create-record.title', ['label' => Str::lower(__('timex::timex.model.label'))])}}
        </x-filament-support::button>
    </div>
</div>

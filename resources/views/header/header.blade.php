<div class="sm:justify-between sm:items-center grid sm:flex gap-2">
    <div class="filament-header-heading text-2xl font-bold tracking-tight">
        {{$this->monthName}}
    </div>
    <div class="flex items-center gap-2 justify-between">
        <div class="flex">
            <x-filament-support::button
                wire:click="$emit('onTodayClick')"
                :size="'sm'"
                :dark-mode="true"
                :color="'secondary'"
                :outlined="config('timex.pages.buttons.outlined')"
            >
                {{config('timex.pages.buttons.today.static') ? trans('timex::timex.labels.today') : self::getDynamicLabel('today')}}
            </x-filament-support::button>
        </div>
        <div class="flex gap-2">
            <x-filament-support::button
                :dark-mode="true"
                :size="'sm'"
                :outlined="true"
            >
                <div class="flex gap-3 items-center">
                    @unless(config('timex.pages.buttons.hideYearNavigation', false))
                        <x-dynamic-component
                            wire:click="$emit('onPreviousYearClick')"
                            :component="config('timex.pages.buttons.icons.previousYear', 'heroicon-o-chevron-double-left')"
                            class="h-4 w-4 text-gray-500"/>
                    @endunless
                    <x-dynamic-component
                        wire:click="$emit('onPrevClick')"
                        :component="config('timex.pages.buttons.icons.previousMonth')"
                        class="h-4 w-4"/>
                    <span
                        class="border-primary-600 dark:border-gray-400 rounded h-3 ml-2 mr-2"
                        style="border-width: 0.5px;">
                    </span>
                    <x-dynamic-component
                        wire:click="$emit('onNextClick')"
                        :component="config('timex.pages.buttons.icons.nextMonth')"
                        class="h-4 w-4"/>
                    @unless(config('timex.pages.buttons.hideYearNavigation', false))
                        <x-dynamic-component
                            wire:click="$emit('onNextYearClick')"
                            :component="config('timex.pages.buttons.icons.nextYear','heroicon-o-chevron-double-right')"
                            class="h-4 w-4 text-gray-500"/>
                    @endunless
                </div>
            </x-filament-support::button>
            <x-filament-support::button
                wire:click="$emit('onCreateClick')"
                :outlined="true"
                :dark-mode="true"
                :size="'sm'">
                    <div class="flex items-center gap-2">
                        <x-dynamic-component
                            :component="config('timex.pages.buttons.icons.createEvent')"
                            class="h-4 w-4"
                        />
                        <div class="hidden lg:flex">
                            {{trans('filament::resources/pages/create-record.title', ['label' => Str::lower(__('timex::timex.model.label'))])}}
                        </div>
                    </div>
            </x-filament-support::button>
        </div>
    </div>
</div>

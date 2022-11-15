@php
    $currentYear = today()->year;
    $chosenYear = \Carbon\Carbon::create($today)->year;
@endphp
<div class="w-full" id="timex-month">
    <div class="flex justify-between items-center w-full dark:border-gray-600 mb-2">
        <div class="flex-1 font-medium text-lg">
            {{$monthName}}
            @if($currentYear != $chosenYear)
                {{$chosenYear}}
            @endif
        </div>
        <div class="flex p-2 gap-2">
            <x-filament-support::button
                wire:click.stop="onPreviousMonthClick()"
                :size="'sm'"
                :outlined="'true'"
                :icon="'heroicon-o-chevron-left'"/>
            <x-filament-support::button
                wire:click="onTodayClick()"
                :size="'sm'"
                :outlined="'true'">
                {{'Today'}}
            </x-filament-support::button>
            <x-filament-support::button
                wire:click.stop="onNextMonthClick()"
                :icon="'heroicon-o-chevron-right'"
                :size="'sm'"
                :outlined="'true'"
                :icon-position="'after'"/>
        </div>
    </div>
    <div class="grid grid-cols-7 text-center bg-white dark:bg-gray-800 dark:border-gray-600 rounded-xl border">
        @foreach(collect($this->getDays())['weekDays'] as $dayOfWeek)
            <div wire:key="{{rand()}}">
                <livewire:timex-week
                    wire:key="{{rand()}}"
                    :name="$dayOfWeek['dayName']"
                    :day-of-week="$dayOfWeek['dayOfWeek']"
                    :days="$dayOfWeek['days']"
                    :last="$loop->last"
                />
            </div>
        @endforeach
    </div>
</div>

@php
    $currentYear = today()->year;
    $chosenYear = \Carbon\Carbon::create($today)->year;
@endphp

<div class="w-full" id="timex-calendar">
    <div
        wire:init="loaded" class="grid grid-cols-7 text-center bg-white dark:bg-gray-800 dark:border-gray-600 rounded-xl border">
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

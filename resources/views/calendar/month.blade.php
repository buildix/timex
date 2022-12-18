<div class="w-full" id="timex-calendar">
    <div
        wire:init="loaded" class="timex-month dark:bg-gray-800 dark:border-gray-600">
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
{{--    <livewire:timex-event-list/>--}}
</div>

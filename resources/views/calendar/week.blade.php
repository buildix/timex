<div>
    <div class="timex-week-name">
        {{$name}}
    </div>
    <div
        @class(
            [
                'timex-week',
                'timex-week-last' => $last,
                'border-r dark:border-gray-600' => !$last,
                'bg-gray-50 dark:bg-gray-700' => in_array($dayOfWeek,\Carbon\Carbon::getWeekendDays()),
            ]
        )
{{--        @if($last)--}}
{{--            style="border-bottom-right-radius: 0.75rem;"--}}
{{--        @endif--}}
    >
        @foreach($days as $day)
            <livewire:timex-day
                :day="$day['day']"
                :timestamp="$day['timestamp']"
                :first="$loop->first"
                :last="$loop->last"
            />
        @endforeach
    </div>
</div>

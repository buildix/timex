@php
    $isDayViewHidden = config('timex.mini.isDayViewHidden');
    $isEventViewHidden = config('timex.mini.isNextMeetingViewHidden');
@endphp
<div class="h-10 pr-2 flex">
    <div @class([
        'hidden' => $isDayViewHidden,
        'pr-2' => !$isEventViewHidden
    ])>
        <livewire:timex-day-widget wire:key="{{rand()}}" wire:poll/>
    </div>
    <div @class([
        'hidden' => $isEventViewHidden,
        'relative group max-w-md rounded-lg bg-gray-400/10 dark:bg-gray-700',
    ])
    style="min-width: 12rem; max-width: 12rem;">
        <livewire:timex-event-widget wire:key="{{rand()}}" wire:poll/>
    </div>
</div>

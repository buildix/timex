<div class="h-10 pr-2 flex">
    @unless(config('timex.mini.isDayViewHidden'))
    <div @class([
        'pr-2' => !config('timex.mini.isNextMeetingViewHidden')
    ])>
        <livewire:timex-day-widget wire:key="{{rand()}}" wire:poll/>
    </div>
    @endunless
    @unless(config('timex.mini.isNextMeetingViewHidden'))
    <div @class([
        'hidden lg:block',
        'relative group max-w-md rounded-lg bg-gray-400/10 dark:bg-gray-700',
    ])
    style="min-width: 14rem; max-width: 14rem;">
        <livewire:timex-event-widget wire:key="{{rand()}}" wire:poll/>
    </div>
    @endunless
</div>

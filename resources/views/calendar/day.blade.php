@php
    $isCurrentDay = \Carbon\Carbon::createFromTimestamp($timestamp)->isCurrentDay();
    $isCurrentMonthDay = \Carbon\Carbon::createFromTimestamp($timestamp)->isCurrentMonth();
    $isWeekend = \Carbon\Carbon::createFromTimestamp($timestamp)->isWeekend();
    $firstDayOfMonth = \Carbon\Carbon::createFromTimestamp($timestamp)->firstOfMonth()->timestamp;
    $isFirstOfMonth = $timestamp == $firstDayOfMonth;

@endphp
<div
    class="group items-center text-left"
    style="height: 130px;"
>
    <div
        @class([
            'text-gray-400' => !$isCurrentMonthDay || $isWeekend,
            'border-t dark:border-gray-600',
            'pl-2 pt-1 py-1'
    ])>
        <span
            @class(
                [
                    'relative inline-flex items-center justify-center text-sm ml-auto rtl:ml-0 rtl:mr-auto font-medium tracking-tight rounded-xl whitespace-normal',
                    'text-white bg-primary-500' => $isCurrentDay,
                    'rounded-full px-3 py-0.5 h-6 -mb-2',
                ]
            )
        >
            <span @class([
                    'absolute',
            ])>
                {{$day}}
            </span>
        </span>
        <span class="absolute">
            <div
                @class([
                'w-32 ml-1 text-xs',
                'hidden' => !$isFirstOfMonth
                ])>
                {{\Carbon\Carbon::createFromTimestamp($timestamp)->shortMonthName}}
            </div>
        </span>
    </div>
    <div class="-mt-2 -pt-2" style="overflow-y: auto; overflow-x: hidden;  overflow-scrolling: touch; height: 88px;">
    <div class="grid grid-flow-row gap-0.5"
         id="{{$timestamp}}"
         data-status-id="{{$timestamp}}">
    @foreach($events as $event)
        <div id="{{ $event->getEventID() }}"
        wire:click="$emitUp('onEventClick','{{$event->getEventID()}}')">
            <livewire:timex-event
                :event-i-d="$event->getEventID()"
                :subject="$event->getSubject()"
                :body="$event->getBody()"
                :color="$event->getColor()"
                :category="$event->getCategory()"
                :start="$event->getStart()"
                :start-time="$event->getStartTime()"
                :icon="$event->getIcon()"/>
        </div>
    @endforeach
    </div>
    </div>
</div>

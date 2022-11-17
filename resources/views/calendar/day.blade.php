@php
    $isCurrentDay = \Carbon\Carbon::createFromTimestamp($timestamp)->isCurrentDay();
    $isCurrentMonthDay = \Carbon\Carbon::createFromTimestamp($timestamp)->isCurrentMonth();
    $isWeekend = \Carbon\Carbon::createFromTimestamp($timestamp)->isWeekend();

@endphp
<div
    class="group items-center text-left"
    style="height: 140px;"
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
                    'rounded-full px-3 py-0.5 h-6',
                ]
            )
        >
            <span class="absolute">
                {{$day}}
            </span>
        </span>
    </div>
    <div class="grid grid-flow-col gap-0.5"
         id="{{$timestamp}}"
         data-status-id="{{$timestamp}}"
    >
    @foreach($events as $event)
        <div id="{{ $event->getEventID() }}"
        wire:click="$emitUp('onEventClick','{{$event->getEventID()}}')">
            <livewire:timex-event
                :event-i-d="$event->getEventID()"
                :subject="$event->getSubject()"
                :body="$event->getBody()"
                :color="$event->getColor()"
                :icon="$event->getIcon()"/>
        </div>
    @endforeach
    </div>
</div>

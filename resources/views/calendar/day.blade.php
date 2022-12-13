<div class="timex-day">
    <div
        @class([
            'text-gray-400' => !$isCurrentMonthDay || $isWeekend,
            'border-t dark:border-gray-600',
            'pl-2 pt-2',
        ])
        wire:click="$emitUp('onDayClick','{{$timestamp}}')">
        <span
            id="day-{{$timestamp}}"
            @class(
                [
                    'relative cursor-pointer inline-flex items-center justify-center text-sm ml-auto rtl:ml-0 rtl:mr-auto font-medium tracking-tight rounded-xl whitespace-normal',
                    'text-white bg-primary-500' => $isCurrentDay,
                    'rounded-full px-3 h-6',
                    'hover:bg-gray-500 hover:text-white'
                ]
            )
        >
            <span @class([
                    'absolute',
            ])>
                {{$day}}
            </span>
        </span>
        @unless(!$isFirstOfMonth)
        <span class="absolute">
            <div
                @class([
                'ml-1 text-xs',
                'hidden lg:block'
                ])>
                {{\Carbon\Carbon::createFromTimestamp($timestamp)->shortMonthName}}
            </div>
        </span>
        @endunless
    </div>
    <div class="hidden lg:block overflow-x-hidden overflow-y-auto scroll-smooth" style="height: 88px;">
        <div class="grid grid-flow-row gap-0.5"
             id="{{$timestamp}}"
             data-status-id="{{$timestamp}}"
        >
                @foreach($events as $event)
                    <div
                        id="{{ $event->getEventID() }}"
                        wire:click="$emitUp('onEventClick','{{$event->getEventID()}}')">
                        <livewire:timex-event
                            :body="$event->getBody()"
                            :category="$event->getCategory()"
                            :color="$event->getColor()"
                            :event-i-d="$event->getEventID()"
                            :icon="$event->getIcon()"
                            :is-all-day="$event->getIsAllDay()"
                            :organizer="$event->getOrganizer()"
                            :start="$event->getStart()"
                            :start-time="$event->getStartTime()"
                            :subject="$event->getSubject()"
                        />
                    </div>
                @endforeach
        </div>
    </div>
    <div class="flex pl-2 gap-0.5 truncate lg:hidden">
        @foreach(collect($events)->take(4) as $event)
            <span
                style="width: 6px; height: 6px"
                @class([
                    'rounded-full',
                    'bg-'.$event->getColor().'-500' => $event->getColor() != 'secondary',
                    'bg-gray-600' => $event->getColor() == 'secondary',
                ])>
            </span>
        @endforeach
    </div>
</div>

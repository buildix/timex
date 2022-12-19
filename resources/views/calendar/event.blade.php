<div class="flex"
     style="height: 20px;">
    <span
        style="width: 4px;"
        @class([
        'h-full ml-1 rounded-md',
        'bg-'.$color.'-600' => $color != 'secondary',
        'bg-gray-600' => $color == 'secondary',
        'hidden' => $isWidgetEvent,
])>

    </span>
    <div
        @class([
        'border border-'.$color.'-600 hover:text-'.$color.'-500' => !$isMyEvent && !$isWidgetEvent,
        'grid grid-cols-7 items-center text-left text-xs font-light cursor-pointer',
        'w-full rounded ml-1 mr-1',
        'hover:bg-'.$color.'-600/20' => $color !== 'secondary' && !$isWidgetEvent,
        'hover:bg-gray-600/20' => $color == 'secondary' && !$isWidgetEvent,
        'text-white hover:text-'.$color.'-500 bg-'.$color.'-500' => $color != 'secondary' && !$isInPast && !$isWidgetEvent && $isMyEvent,
        'text-white hover:text-gray-500 bg-gray-500' => $color == 'secondary' && !$isInPast && !$isWidgetEvent && $isMyEvent,
        ])
    >

        @if($icon)
        <div class="mr-1 ml-1 col-span-1">
            <x-dynamic-component
                :component="$icon"
                @class([
                'h-4 w-4 shrink-0',
                'text-'.$color.'-500' => $isWidgetEvent && $color !== 'secondary',
                'text-gray-500' => $isWidgetEvent && $color == 'secondary',
                ])
            />
        </div>
        @endif
        <div @class([
                'mr-1 ml-1 col-span-5 truncate' => !$icon,
                'col-span-4 truncate' => $icon,
        ])>
            {{$subject}}
        </div>
        <div @class([
                'col-span-2 ml-2 truncate' => !$isWidgetEvent,
                'col-span-2 ml-4 truncate' => $isWidgetEvent
            ])>
            @if($isAllDay || config('timex.resources.isStartEndHidden',false))
                {{config('timex.resources.isStartEndHidden',false) ? '' : trans('timex::timex.event.allDay')}}
            @else
                {{\Carbon\Carbon::parse($startTime)->isoFormat('H:mm')}}
            @endif
        </div>
    </div>

</div>

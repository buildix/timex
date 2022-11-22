@php
    $icon = config('timex.categories.icons.'.$category);
    $color = config('timex.categories.colors.'.$color);
    $eventStart = \Carbon\Carbon::createFromTimestamp($start)->setHours(23);
    $isInPast =  $eventStart->isPast();
@endphp

<div class="flex"
     style="height: 20px;">
    <span
        style="width: 4px;"
        @class([
        'h-full ml-1 rounded-md',
        'bg-'.$color.'-600' => $color != 'secondary',
        'bg-gray-600' => $color == 'secondary',
])>

    </span>
    <div
        @class([
        'grid grid-cols-7 items-center text-left text-xs font-light cursor-pointer',
        'w-full rounded ml-1 mr-1',
        'hover:bg-'.$color.'-600/20' => $color !== 'secondary',
        'hover:bg-gray-600/20' => $color == 'secondary',
        'text-white hover:text-'.$color.'-500 bg-'.$color.'-500' => $color != 'secondary' && !$isInPast,
        'text-white hover:text-gray-500 bg-gray-500' => $color == 'secondary' && !$isInPast,
        ])
    >

        @if($icon)
        <div class="mr-1 ml-1 col-span-1">
            <x-dynamic-component
                :component="$icon"
                class="h-4 w-4 shrink-0"
            />
        </div>
        @endif
        <div @class([
                'mr-1 ml-1 col-span-5 truncate' => !$icon,
                'col-span-4 truncate' => $icon
        ])>
            {{$subject}}
        </div>
        <div class="col-span-2 ml-2">
            {{\Carbon\Carbon::parse($startTime)->isoFormat('H:mm')}}
        </div>
    </div>

</div>

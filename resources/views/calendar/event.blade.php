@php
    $icon = match ($category){
        default => null,
        'primary' => 'heroicon-o-calendar',
        'danger' => 'heroicon-o-user-group',
        'secondary' => 'heroicon-o-phone',
        'success' => 'heroicon-o-presentation-chart-bar',
    }
@endphp

<div class="flex"
     style="height: 20px;">
    <span
        style="width: 4px;"
        @class([
        'h-full ml-1 rounded-md',
        match ($color){
            default => 'bg-primary-600',
            'danger' => 'bg-danger-600',
            'success' => 'bg-success-600',
            'warning' => 'bg-warning-600',
            'secondary' => 'bg-gray-600',
            }
])>

    </span>
    <div
        @class([
        'grid grid-cols-7 items-center text-left text-xs font-light cursor-pointer',
        'w-full rounded ml-1 mr-1',
        'hover:bg-'.$color.'-600/20' => $color !== 'secondary',
        'hover:bg-gray-600/20' => $color == 'secondary',
        match ($color){
            default => 'text-white hover:text-primary-500 bg-primary-500',
            'danger' => 'text-white hover:text-danger-500 bg-danger-500',
            'success' => 'text-white hover:text-success-500 bg-success-500',
            'warning' => 'text-white hover:text-warning-500 bg-warning-500',
            'secondary' => 'text-white hover:text-gray-500 bg-gray-500',
            }
        ])
            style="border-style: solid; border-width: 0.2px; border-color: currentColor;"
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

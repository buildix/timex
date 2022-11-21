@php
    $currentYear = today()->year;
    $chosenYear = \Carbon\Carbon::create($today)->year;
@endphp

<div class="w-full" id="timex-calendar">
{{--    <div class="flex-1 font-medium text-lg">--}}
{{--                    {{$monthName}}--}}
{{--                    @if($currentYear != $chosenYear)--}}
{{--                        {{$chosenYear}}--}}
{{--                    @endif--}}
{{--                </div>--}}
{{--    <div class="flex justify-between items-center w-full dark:border-gray-600 mb-2">--}}
{{--        <div class="flex-1 font-medium text-lg">--}}
{{--            {{$monthName}}--}}
{{--            @if($currentYear != $chosenYear)--}}
{{--                {{$chosenYear}}--}}
{{--            @endif--}}
{{--        </div>--}}
{{--        <div class="grid grid-cols-3 items-center">--}}
{{--            <div>--}}
{{--                <x-filament::dropdown placement="bottom-end">--}}
{{--                    <x-slot name="trigger">--}}
{{--                        <div class="mx-2">--}}
{{--                            <x-filament-support::button--}}
{{--                        wire:click.stop="onPreviousMonthClick()"--}}
{{--                                :size="'sm'"--}}
{{--                                :outlined="'true'"--}}
{{--                                :icon="'heroicon-o-plus'">--}}
{{--                                {{"Create"}}--}}
{{--                            </x-filament-support::button>--}}
{{--                        </div>--}}
{{--                    </x-slot>--}}
{{--                    <x-filament::dropdown.list>--}}
{{--                        <x-filament-support::dropdown.list.item--}}
{{--                        :icon="'heroicon-o-calendar'">--}}
{{--                            {{"Event"}}--}}
{{--                        </x-filament-support::dropdown.list.item>--}}
{{--                        <x-filament-support::dropdown.list.item--}}
{{--                        :icon="'heroicon-o-user-group'">--}}
{{--                            {{"Meeting"}}--}}
{{--                        </x-filament-support::dropdown.list.item>--}}
{{--                    </x-filament::dropdown.list>--}}
{{--                </x-filament::dropdown>--}}
{{--            </div>--}}
{{--            <div class="flex p-2 gap-1 col-span-2">--}}
{{--                <x-filament-support::button--}}
{{--                    wire:click.stop="onPreviousMonthClick()"--}}
{{--                    :size="'sm'"--}}
{{--                    :outlined="'true'">--}}
{{--                    <x-dynamic-component--}}
{{--                        :component="'heroicon-o-chevron-left'"--}}
{{--                        class="h-4 w-4 shrink-0"/>--}}
{{--                </x-filament-support::button>--}}
{{--                <x-filament-support::button--}}
{{--                    wire:click.stop="onTodayClick()"--}}
{{--                    :size="'sm'"--}}
{{--                    :outlined="'true'">--}}
{{--                    {{\Carbon\Carbon::today()->format('d M')}}--}}
{{--                </x-filament-support::button>--}}
{{--                <x-filament-support::button--}}
{{--                    wire:click.stop="onNextMonthClick()"--}}
{{--                    :size="'sm'"--}}
{{--                    :outlined="'true'"--}}
{{--                    :icon-position="'after'">--}}
{{--                    <x-dynamic-component--}}
{{--                        :component="'heroicon-o-chevron-right'"--}}
{{--                        class="h-4 w-4 shrink-0"/>--}}
{{--                </x-filament-support::button>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
    <div
        wire:init="loaded" class="grid grid-cols-7 text-center bg-white dark:bg-gray-800 dark:border-gray-600 rounded-xl border">
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
</div>

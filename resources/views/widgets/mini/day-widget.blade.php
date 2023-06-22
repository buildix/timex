<div id="timex--day-widget" wire:click="openCalendar()"
    @class([ 'group cursor-pointer text-center rounded-lg bg-gray-400/10' , 'hover:bg-gray-500/10 dark:bg-gray-700' ])
    style="width: 4.5rem;">
    <div class="text-xs font-medium text-primary-600 dark:text-primary-500">
        {{$monthName.'.'}}
    </div>
    <div class="content-center items-center grid grid-cols-2 px-2 ml-1 mr-2 rtl:mr-1 rtl:ml-2">
        <div class="font-medium text-center -ml-2 rtl:-mr-2 rtl:ml-0">
            {{$day}}
        </div>
        <div class="font-medium text-xs">
            {{$dayName}}
        </div>
    </div>
</div>
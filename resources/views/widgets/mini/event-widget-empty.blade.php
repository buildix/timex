<div class="flex items-center pl-2 rtl:pr-2 rtl:pl-0 h-10 text-gray-500 dark:text-gray-400">
    <x-heroicon-o-calendar class="w-5 h-5" />
    <div class="ml-2 rtl:mr-2 rtl:ml-0 px-2">
        {{trans('timex::timex.events.empty', ['label' => Str::lower(trans('timex::timex.model.pluralLabel'))])}}
    </div>
</div>
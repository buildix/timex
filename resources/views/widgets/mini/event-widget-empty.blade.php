<div class="flex items-center pl-2 h-10 text-gray-500 dark:text-gray-400">
    <x-heroicon-o-calendar class="w-5 h-5"/>
    <div class="ml-2" style="font-weight: 200; font-size: 0.95rem; line-height: 1.5rem;">
        {{__('timex::timex.events.empty', ['label' => Str::lower(__('timex::timex.model.pluralLabel'))])}}
    </div>
</div>

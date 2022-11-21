{{--<x-filament::form wire:ignore.self wire:submit.prevent="onEditRecordSubmit">--}}
{{--    <x-filament::modal id="timex--event-modal" :width="'7xl'">--}}
{{--        <x-slot name="header">--}}
{{--            <x-filament::modal.heading>--}}
{{--                {{ "Heading" }}--}}
{{--            </x-filament::modal.heading>--}}
{{--        </x-slot>--}}
{{--        {{ $this->eventModal }}--}}
{{--        <x-slot name="footer">--}}
{{--            <x-filament::button type="submit" form="onEditRecordSubmit">--}}
{{--                {{$this->getEditModalSaveButtonLabel()}}--}}
{{--            </x-filament::button>--}}
{{--            <x-filament::button color="secondary" x-on:click="isOpen = false">--}}
{{--                {{$this->getEditModalCancelButtonLabel()}}--}}
{{--            </x-filament::button>--}}
{{--        </x-slot>--}}
{{--    </x-filament::modal>--}}
{{--</x-filament::form>--}}

{{--<x-tables::modal--}}
{{--    :id="$this->id . '-table-action'"--}}
{{--    :wire:key="$action ? $this->id . '.table.actions.' . $action->getName() . '.modal' : null"--}}
{{--    :visible="filled($action)"--}}
{{--    :width="$action?->getModalWidth()"--}}
{{--    :slide-over="$action?->isModalSlideOver()"--}}
{{--    display-classes="block"--}}
{{--    x-init="this.livewire = $wire.__instance"--}}
{{--    x-on:modal-closed.stop="--}}
{{--                if ('mountedTableAction' in this.livewire?.serverMemo.data) {--}}
{{--                    this.livewire.set('mountedTableAction', null)--}}
{{--                }--}}

{{--                if ('mountedTableActionRecord' in this.livewire?.serverMemo.data) {--}}
{{--                    this.livewire.set('mountedTableActionRecord', null)--}}
{{--                }--}}
{{--            "--}}
{{-->--}}
{{--    @if ($action)--}}
{{--        @if ($action->isModalCentered())--}}
{{--            <x-slot name="heading">--}}
{{--                {{ $action->getModalHeading() }}--}}
{{--            </x-slot>--}}

{{--            @if ($subheading = $action->getModalSubheading())--}}
{{--                <x-slot name="subheading">--}}
{{--                    {{ $subheading }}--}}
{{--                </x-slot>--}}
{{--            @endif--}}
{{--        @else--}}
{{--            <x-slot name="header">--}}
{{--                <x-tables::modal.heading>--}}
{{--                    {{ $action->getModalHeading() }}--}}
{{--                </x-tables::modal.heading>--}}

{{--                @if ($subheading = $action->getModalSubheading())--}}
{{--                    <x-tables::modal.subheading>--}}
{{--                        {{ $subheading }}--}}
{{--                    </x-tables::modal.subheading>--}}
{{--                @endif--}}
{{--            </x-slot>--}}
{{--        @endif--}}

{{--        {{ $action->getModalContent() }}--}}

{{--        @if ($action->hasFormSchema())--}}
{{--            {{ $getMountedActionForm() }}--}}
{{--        @endif--}}

{{--        {{ $action->getModalFooter() }}--}}

{{--        @if (count($action->getModalActions()))--}}
{{--            <x-slot name="footer">--}}
{{--                <x-tables::modal.actions :full-width="$action->isModalCentered()">--}}
{{--                    @foreach ($action->getModalActions() as $modalAction)--}}
{{--                        {{ $modalAction }}--}}
{{--                    @endforeach--}}
{{--                </x-tables::modal.actions>--}}
{{--            </x-slot>--}}
{{--        @endif--}}
{{--    @endif--}}
{{--</x-tables::modal>--}}
<x-filament-support::modal
    id="timex--event-modal"
    :wire:key="$this->id .'.timex-event-modal.'"
    :slide-over="true"
    :header="'3232'"
    :dark-mode="true"
    :width="'7xl'">
    <form wire:submit.prevent="onEventSubmit">
        {{$this->form}}
    </form>
</x-filament-support::modal>

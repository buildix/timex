{{--@php--}}
{{--    $events = $this->getEvents();--}}
{{--@endphp--}}
<x-filament::page>
<div wire:key="{{rand()}}">
    <livewire:timex-month/>
</div>
{{--<div>--}}
{{--    @foreach($events as $event)--}}
{{--        <livewire:timex-event--}}
{{--            :subject="$event->getSubject()"--}}
{{--            :body="$event->getBody()"/>--}}
{{--    @endforeach--}}
{{--</div>--}}
    <script></script>
</x-filament::page>

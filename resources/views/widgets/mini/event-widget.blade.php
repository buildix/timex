<div class="grid grid-flow-row" style="overflow-y: auto; overflow-x: hidden;  overflow-scrolling: touch; height: 40px;">
    @foreach($events as $event)
        <div id="{{ $event->getEventID() }}">
            <livewire:timex-event
                wire:key="{{rand()}}"
                :event-i-d="$event->getEventID()"
                :subject="$event->getSubject()"
                :body="$event->getBody()"
                :color="$event->getColor()"
                :category="$event->getCategory()"
                :start="$event->getStart()"
                :start-time="$event->getStartTime()"
                :icon="$event->getIcon()"
                :is-widget-event="true"/>
        </div>
    @endforeach
</div>

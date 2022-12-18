@php
    $event = new \Illuminate\Support\Fluent($data);
    $startTime = \Carbon\Carbon::create($event->startTime);
    $endTime = \Carbon\Carbon::create($event->endTime);
    $start = \Carbon\Carbon::create($event->start)->setTimeFrom($startTime);
    $end = \Carbon\Carbon::create($event->end)->setTimeFrom($endTime);
    if (self::isCategoryModelEnabled() || \Str::isUuid($event->category)){
        $model = self::getCategoryModel()::query()->find($event->category)->getAttributes();
        $color = $model[self::getCategoryModelColumn('color')];
        $name = $model[self::getCategoryModelColumn('value')];
    }else{
        $color = $event->category ? config('timex.categories.colors.'.$event->category) : 'primary';
        $name = config('timex.categories.labels.'.$event->category);
    }
    $participants = json_decode($event?->participants);
    $attachments = json_decode($event?->attachments);

    if ($start == $end){
        $duration = $endTime->shortRelativeDiffForHumans($startTime);
    }else{
        $duration = $end->shortAbsoluteDiffForHumans($start,3);
    }
@endphp
<div>
    <div class="flex gap-4 pb-2 items-center">
        <x-dynamic-component
            :component="config('timex.pages.buttons.modal.view.time','heroicon-o-clock')"
            class="h-5 w-5"/>
        <div>
            {{$start->isoFormat('dddd, D MMM Y')}}
            <div class="flex gap-2 items-center text-xs">
                <div>
                    {{$startTime->isoFormat('H:mm')}}
                </div>
                <div>
                    <x-dynamic-component
                        :component="'heroicon-o-arrow-narrow-right'"
                        class="h-4 w-4"/>
                </div>
                <div>
                    @if($event->start !== $event->end)
                        {{$end->isoFormat('H:mm, D.M.Y')}}
                    @else
                        {{$endTime->isoFormat('H:mm')}}
                    @endif
                </div>
                <div>
                    ({{$duration}})
                </div>
            </div>
        </div>
    </div>
    @unless(!$event->category && !self::isCategoryModelEnabled())
        <div class="flex gap-4 pb-2 items-center text-xs">
            <div>
                <x-dynamic-component
                    :component="config('timex.pages.buttons.modal.view.category','heroicon-o-tag')"
                    class="h-5 w-5"/>
            </div>
            <div @class([
                'bg-'.$color.'-500/10 text-'.$color.'-500' => $color !== 'secondary',
                'bg-gray-500/10 text-gray-500' => $color == 'secondary',
                'rounded-xl',
                'pl-2 pr-2',
            ])>
                {{$name}}
            </div>
        </div>
    @endunless
    @unless(!$event->body)
        <div class="flex gap-4 pt-2 items-start">
            <div class="mt-1">
                <x-dynamic-component
                    :component="config('timex.pages.buttons.modal.view.body','heroicon-o-annotation')"
                    class="h-5 w-5"/>
            </div>
            <div class="pb-2">
                {{\Livewire\str($event->body)->toHtmlString()}}
            </div>
        </div>
    @endunless
    @unless(!$participants)
        <div class="flex gap-4 items-center pt-2 pb-2">
            <div>
                <x-dynamic-component
                    :component="config('timex.pages.buttons.modal.view.participants','heroicon-o-user-group')"
                    class="h-5 w-5"/>
            </div>
            <div class="flex gap-2">
                @foreach($participants as $participant)
                    @php
                        $user = \App\Models\User::find($participant)
                    @endphp
                    <div class="flex items-center gap-2">
                        <div @class([
                            'w-7 h-7 rounded-full bg-gray-200 bg-cover bg-center',
                            'dark:bg-gray-900' => config('filament.dark_mode'),
                        ])
                         style="background-image: url('{{ \Filament\Facades\Filament::getUserAvatarUrl($user) }}')">
                        </div>
                        <div class="text-sm">
                            {{$user->name}}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endunless
    @unless(!$attachments)
        <x-filament::hr class="mt-2 mb-2"/>
        <div class="grid grid-cols-1 divide-y border rounded-md mt-2">
            @foreach($attachments as $attachment)
                <div class="p-2 flex justify-between">
                    <div class="flex items-center gap-2">
                        <div>
                            <x-dynamic-component
                                :component="'heroicon-o-paper-clip'"
                                class="h-4 w-4"/>
                        </div>
                        <div class="text-sm">
                            {{$attachment}}
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <x-filament-support::icon-button
                            :icon="'heroicon-o-download'"
                            :size="'sm'"
                            wire:click="loadAttachment('{{$attachment}}')"/>
                    </div>
                </div>
            @endforeach
        </div>
    @endunless
</div>

<?php

namespace Buildix\Timex\Events;

use Carbon\Carbon;
use Closure;

class EventItem
{
    protected ?string $body = null;
    protected ?string $category = null;
    public ?string $color = null;
    public $end;
    public $endTime;
    protected $eventID;
    protected ?string $icon = null;
    public bool $isAllDay;
    public $organizer;
    public $participants = [];
    public $start;
    public ?string $startTime = null;
    protected string $subject;
    protected $type;




    final public function __construct($eventID)
    {
            $this->eventID($eventID);
    }

    public function body(?string $body): static
    {
        $this->body = $body;

        return $this;
    }

    public function category(?string $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function color(?string $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function end(Carbon $end): static
    {
        $this->end = $end->setHour(0)->setMinute(0)->setSeconds(0)->timestamp;

        return $this;
    }

    public function eventID($eventID)
    {
        $this->eventID = $eventID;

        return $this;
    }

    public static function make($eventID): static
    {
        return app(static::class, ['eventID' => $eventID]);
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function start(Carbon $start): static
    {
        $this->start = $start->setHour(0)->setMinute(0)->setSeconds(0)->timestamp;

        return $this;
    }

    public function startTime(?string $startTime):static
    {
        $this->startTime = $startTime;

        return $this;
    }

    public function getStartTime(): ?string
    {
        return $this->startTime;
    }

    public function subject(string $subject): static
    {
        $this->subject = $subject;

        return $this;
    }

    public function organizer(string $organizer)
    {
        $this->organizer = $organizer;

        return $this;
    }

    public function participants(?array $participants)
    {
        $this->participants = $participants;

        return $this;
    }

    public function getColor(): ?string
    {
        return isset($this->color) ? $this->color : 'primary';
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function getOrganizer()
    {
        return $this->organizer;
    }

    public function getStart()
    {
        return $this->start;
    }

    public function getEnd(): Carbon
    {
        return $this->end;
    }

    public function getEventID()
    {
        return $this->eventID;
    }

    public function icon(?string $icon): static
    {
        $this->icon = $icon;

        return $this;
    }

    public function isAllDay(bool $isAllDay): static
    {
        $this->isAllDay = $isAllDay;

        return $this;

    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function getIsAllDay(): bool
    {
        return $this->isAllDay;
    }

}

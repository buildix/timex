<?php

namespace Buildix\Timex\Events;

use Carbon\Carbon;
use Closure;

class EventItem
{
    protected $eventID;
    protected string $subject;
    protected ?string $body = null;
    public $start;
    public $end;
    public ?string $color = null;
    public Carbon $startTime;
    public Carbon $endTime;
    protected $type;
    protected ?string $icon = null;
    protected ?string $category = null;


    final public function __construct($eventID)
    {
            $this->eventID($eventID);
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

    public function category(?string $category): static
    {
        $this->category = $category;

        return $this;
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

    public function startTime(Carbon $startTime):static
    {
        $this->startTime = $startTime;

        return $this;
    }

    public function getStartTime(): Carbon
    {
        return $this->startTime;
    }

    public function end(Carbon $end): static
    {
        $this->end = $end->setHour(0)->setMinute(0)->setSeconds(0)->timestamp;

        return $this;
    }

    public function subject(string $subject): static
    {
        $this->subject = $subject;

        return $this;
    }

    public function body(?string $body): static
    {
        $this->body = $body;

        return $this;

    }
    public function color(?string $color): static
    {
        $this->color = $color;

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

    public function getIcon(): ?string
    {
        return $this->icon;
    }

}

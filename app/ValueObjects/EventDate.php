<?php

namespace App\ValueObjects;

use JsonSerializable;
use Illuminate\Support\Carbon;

class EventDate implements JsonSerializable
{
    protected ?Carbon $start = null;
    protected ?Carbon $end = null;

    public function __construct($start = null, $end = null)
    {
        if (!is_null($start) && $start instanceof Carbon === false) {
            $start = Carbon::parse($start);
        }
        if (!is_null($end) && $end instanceof Carbon === false) {
            $end = Carbon::parse($end);
        }

        $this->setStart($start);
        $this->setEnd($end);
    }

    public function getStart(): ?Carbon
    {
        return $this->start;
    }

    public function getEnd(): ?Carbon
    {
        return $this->end;
    }

    public function setStart(?Carbon $date): void
    {
        $this->start = $date;
    }

    public function setEnd(?Carbon $date): void
    {
        $this->end = $date;
    }

    public function jsonSerialize()
    {
        return [
            'start' => $this->getStart(),
            'end' => $this->getEnd(),
        ];
    }
}

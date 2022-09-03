<?php

namespace App\Serializers;

use JsonSerializable;
use Illuminate\Support\Carbon;

class EventDateSerializer implements JsonSerializable
{
    public function __construct(protected ?Carbon $start = null, protected ?Carbon $end = null)
    {
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
            'start' => $this->start,
            'end' => $this->end,
        ];
    }
}

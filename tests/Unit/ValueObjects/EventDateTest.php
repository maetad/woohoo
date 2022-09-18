<?php

namespace Tests\Unit\ValueObjects;

use App\ValueObjects\EventDate;
use Illuminate\Support\Carbon;
use PHPUnit\Framework\TestCase;

class EventDateTest extends TestCase
{
    protected Carbon $today;
    protected Carbon $tomorrow;
    protected EventDate $eventData;

    public function setUp(): void
    {
        $this->today = Carbon::today();
        $this->tomorrow = Carbon::tomorrow();
        $this->eventData = new EventDate($this->today, $this->tomorrow);
    }

    /**
     * Test getter
     *
     * @return void
     */
    public function test_getter()
    {
        $this->assertEquals($this->today, $this->eventData->getStart());
        $this->assertEquals($this->tomorrow, $this->eventData->getEnd());
    }
}

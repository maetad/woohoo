<?php

namespace Tests\Unit\Casts;

use App\Serializers\EventDateSerializer;
use Illuminate\Support\Carbon;
use PHPUnit\Framework\TestCase;

class EventDateSerializerTest extends TestCase
{
    protected Carbon $today;
    protected Carbon $tomorrow;
    protected EventDateSerializer $serializer;

    public function setUp(): void
    {
        $this->today = Carbon::today();
        $this->tomorrow = Carbon::tomorrow();
        $this->serializer = new EventDateSerializer($this->today, $this->tomorrow);
    }

    /**
     * Test getter
     *
     * @return void
     */
    public function test_getter()
    {
        $this->assertEquals($this->today, $this->serializer->getStart());
        $this->assertEquals($this->tomorrow, $this->serializer->getEnd());
    }
}

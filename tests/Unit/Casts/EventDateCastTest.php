<?php

namespace Tests\Unit\Casts;

use App\Casts\EventDateCast;
use App\ValueObjects\EventDate;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use PHPUnit\Framework\TestCase;

class EventDateCastTest extends TestCase
{
    /**
     * Test get.
     *
     * @return void
     */
    public function test_get()
    {
        $model = $this->createMock(Model::class);
        $value = '[{}]';
        $attributes = [];

        $caster = new EventDateCast();
        $cast = $caster->get($model, 'dates', $value, $attributes);

        $this->assertInstanceOf(Collection::class, $cast);
        $this->assertInstanceOf(EventDate::class, $cast->first());
    }
    /**
     * Test set.
     *
     * @return void
     */
    public function test_set()
    {
        $today = new Carbon('2022-01-01 10:00:00');
        $tomorrow = new Carbon('2022-01-01 19:00:00');
        $model = $this->createMock(Model::class);
        $value = collect([
            new EventDate(),
            new EventDate($today, $tomorrow),
        ]);

        $attributes = [];

        $caster = new EventDateCast();
        $result = $caster->set($model, 'dates', $value, $attributes);

        $this->assertEquals('[{"start":null,"end":null},{"start":"2022-01-01T10:00:00.000000Z","end":"2022-01-01T19:00:00.000000Z"}]', $result);
    }
}

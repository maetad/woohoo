<?php

namespace Tests\Http\Requests\Tanant\Event;

use App\Enums\EventStatus;
use App\Http\Requests\Tanant\Event\UpdateRequest;
use Illuminate\Validation\Rule;
use PHPUnit\Framework\TestCase;

class UpdateRequestTest extends TestCase
{
    public function test_authorize()
    {
        $request = new UpdateRequest;
        $this->assertTrue($request->authorize());
    }

    public function test_rules()
    {
        $request = new UpdateRequest;
        $this->assertEquals([
            'name' => 'required',
            'dates.*.start' => 'date',
            'dates.*.end' => 'date',
            'status' => Rule::in(array_column(EventStatus::cases(), 'name')),
        ], $request->rules());
    }
}

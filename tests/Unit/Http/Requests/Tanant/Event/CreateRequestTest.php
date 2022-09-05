<?php

namespace Tests\Unit\Casts;

use App\Enums\EventStatus;
use App\Http\Requests\Tanant\Event\CreateRequest;
use Illuminate\Validation\Rule;
use PHPUnit\Framework\TestCase;

class CreateRequestTest extends TestCase
{
    public function test_authorize()
    {
        $request = new CreateRequest;
        $this->assertTrue($request->authorize());
    }

    public function test_rules()
    {
        $request = new CreateRequest;
        $this->assertEquals([
            'name' => 'required',
            'status' => Rule::in(EventStatus::cases()),
        ], $request->rules());
    }
}

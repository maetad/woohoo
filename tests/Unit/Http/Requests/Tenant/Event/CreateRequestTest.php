<?php

namespace Tests\Unit\Http\Requests\Tenant\Event;

use App\Enums\EventStatus;
use App\Http\Requests\Tenant\Event\CreateRequest;
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
            'dates.*.start' => 'date',
            'dates.*.end' => 'date',
            'status' => Rule::in(array_column(EventStatus::cases(), 'name')),
        ], $request->rules());
    }
}

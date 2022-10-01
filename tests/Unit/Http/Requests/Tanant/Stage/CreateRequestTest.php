<?php

namespace Tests\Unit\Casts;

use App\Http\Requests\Tanant\Stage\CreateRequest;
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
        ], $request->rules());
    }
}

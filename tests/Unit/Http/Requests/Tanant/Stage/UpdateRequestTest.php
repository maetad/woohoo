<?php

namespace Tests\Unit\Http\Requests\Tanant\Stage;

use App\Http\Requests\Tanant\Stage\UpdateRequest;
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
        ], $request->rules());
    }
}

<?php

namespace Tests\Unit\Http\Requests\Tenant\Stage;

use App\Http\Requests\Tenant\Stage\CreateRequest;
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

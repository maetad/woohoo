<?php

namespace Tests\Unit\Http\Requests\Tenant;

use App\Http\Requests\Tenant\StoreRequest;
use PHPUnit\Framework\TestCase;

class StoreRequestTest extends TestCase
{
    public function test_it_should_return_rules()
    {
        $request = new StoreRequest;
        $this->assertEquals([
            'name' => 'required',
        ], $request->rules());
    }
}

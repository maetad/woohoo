<?php

namespace Tests\Unit\Http\Requests\Tenant;

use App\Http\Requests\Tenant\UpdateRequest;
use PHPUnit\Framework\TestCase;

class UpdateRequestTest extends TestCase
{
    public function test_it_should_return_rules()
    {
        $request = new UpdateRequest;
        $this->assertEquals([
            'name' => 'required',
        ], $request->rules());
    }
}

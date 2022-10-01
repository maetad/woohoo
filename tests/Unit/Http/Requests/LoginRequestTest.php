<?php

namespace Tests\Unit\Http\Requests;

use App\Http\Requests\LoginRequest;
use PHPUnit\Framework\TestCase;

class LoginRequestTest extends TestCase
{
    public function test_it_should_return_rules()
    {
        $request = new LoginRequest;
        $this->assertEquals([
            'email' => 'required',
            'password' => 'required',
            'remember' => 'boolean',
        ], $request->rules());
    }
}

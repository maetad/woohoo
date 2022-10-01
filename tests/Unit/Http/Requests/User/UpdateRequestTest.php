<?php

namespace Tests\Http\Requests\User;

use App\Http\Requests\User\UpdateRequest;
use Illuminate\Validation\Rules\Password;
use PHPUnit\Framework\TestCase;

class UpdateRequestTest extends TestCase
{
    public function test_it_should_return_rules()
    {
        $request = new UpdateRequest;
        $this->assertEquals([
            'name' => 'required',
            'password' => [
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ]
        ], $request->rules());
    }
}

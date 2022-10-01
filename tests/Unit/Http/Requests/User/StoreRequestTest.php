<?php

namespace Tests\Http\Requests\User;

use App\Models\User;
use App\Http\Requests\User\StoreRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rules\Unique;
use PHPUnit\Framework\TestCase;

class StoreRequestTest extends TestCase
{
    public function test_it_should_return_rules()
    {
        $request = new StoreRequest;
        $this->assertEquals([
            'name' => 'required',
            'email' => [
                'email',
                'required',
                new Unique(User::class, 'email'),
            ],
            'password' => [
                'required',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ]
        ], $request->rules());
    }
}

<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\AuthenticationController;
use App\Http\Requests\LoginRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class AuthenticationControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_should_login_success()
    {
        $this->seed();

        $request = LoginRequest::create(
            '',
            Request::METHOD_POST,
            [
                'email' => 'admin@example.com',
                'password' => 'password',
                'remember' => true,
            ],
        );

        $controller = new AuthenticationController;
        $response = $controller->login($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(JsonResponse::HTTP_OK, $response->status());
    }

    public function test_it_should_login_fail()
    {
        $this->seed();

        $request = LoginRequest::create(
            '',
            Request::METHOD_POST,
            [
                'email' => 'admin@example.com',
                'password' => 'p@ssword',
                'remember' => true,
            ],
        );

        $controller = new AuthenticationController;

        $this->assertThrows(
            fn () => $controller->login($request),
            ValidationException::class
        );
    }
}

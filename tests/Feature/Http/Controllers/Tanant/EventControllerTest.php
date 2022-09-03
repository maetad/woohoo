<?php

namespace Tests\Feature\Http\Controllers\Tanant;

use App\Http\Controllers\Tanant\EventController;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Tests\TestCase;

class EventControllerTest extends TestCase
{
    // use RefreshDatabase;

    protected $tenancy = true;

    /**
     * Test index with default request.
     *
     * @return void
     */
    public function test_index()
    {
        Event::factory()->count(2)->create();
        $controller = new EventController;
        $response = $controller->index();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(JsonResponse::HTTP_OK, $response->status());
        $this->assertCount(2, json_decode($response->content(), true));
    }
}

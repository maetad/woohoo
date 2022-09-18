<?php

namespace Tests\Feature\Http\Controllers\Tanant;

use App\Enums\EventStatus;
use App\Http\Controllers\Tanant\EventController;
use App\Http\Requests\Tanant\Event\CreateRequest;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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

    /**
     * Test store
     *
     * @return void
     */
    public function test_store_should_return_created()
    {
        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();

        $request = CreateRequest::create(
            '',
            Request::METHOD_POST,
            [
                'name' => 'event-name',
                'detail' => 'event-detail',
                'status' => EventStatus::INITIATE->value,
                'dates' => [
                    ['start' => $today, 'end' => $tomorrow]
                ],
            ],
        );
        $controller = new EventController;
        $response = $controller->store($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(JsonResponse::HTTP_CREATED, $response->status());
        $this->assertStringContainsString('event-name', $response->content());
        $this->assertStringContainsString('event-detail', $response->content());
        $this->assertStringContainsString($today->jsonSerialize(), $response->content());
        $this->assertStringContainsString($tomorrow->jsonSerialize(), $response->content());
        $this->assertStringContainsString(EventStatus::INITIATE->value, $response->content());
    }
}

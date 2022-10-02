<?php

namespace Tests\Feature\Http\Controllers\Tenant;

use App\Http\Controllers\Tenant\EventStageController;
use App\Http\Requests\Tenant\Stage\CreateRequest;
use App\Http\Requests\Tenant\Stage\UpdateRequest;
use App\Models\Event;
use App\Models\Stage;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tests\TestCase;

class EventStageControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $tenancy = true;

    protected Event $event;

    public function setUp(): void
    {
        parent::setUp();

        $this->event = Event::factory()->create();
    }

    /**
     * Test index with default request.
     *
     * @return void
     */
    public function test_index()
    {
        Stage::factory()->count(2)->for($this->event)->create();
        $controller = new EventStageController;
        $response = $controller->index($this->event);

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
        $request = CreateRequest::create(
            '',
            Request::METHOD_POST,
            [
                'name' => 'stage-name',
                'detail' => 'stage-detail',
            ],
        );
        $controller = new EventStageController;
        $response = $controller->store($request, $this->event);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(JsonResponse::HTTP_CREATED, $response->status());
        $this->assertStringContainsString('stage-name', $response->content());
        $this->assertStringContainsString('stage-detail', $response->content());
    }

    /**
     * Test show.
     *
     * @return void
     */
    public function test_show_should_return_correct_event()
    {
        $event = Event::factory()->create();
        $stage = Stage::factory()->for($event)->create();
        $controller = new EventStageController;
        $response = $controller->show($event, $stage);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(JsonResponse::HTTP_OK, $response->status());
        $this->assertEquals($stage->id, json_decode($response->content())?->id);
    }

    /**
     * Test update.
     *
     * @return void
     */
    public function test_update_should_update_the_event()
    {
        $event = Event::factory()->create();
        $stage = Stage::factory()->for($event)->create();

        $request = UpdateRequest::create(
            '',
            Request::METHOD_PUT,
            [
                'name' => 'update-event-name',
                'detail' => 'update-event-detail',
            ],
        );
        $controller = new EventStageController;
        $response = $controller->update($request, $event, $stage);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(JsonResponse::HTTP_OK, $response->status());
        $this->assertStringContainsString('update-event-name', $response->content());
        $this->assertStringContainsString('update-event-detail', $response->content());
    }

    /**
     * Test destroy.
     *
     * @return void
     */
    public function test_destroy_should_return_no_content()
    {
        $event = Event::factory()->create();
        $stage = Stage::factory()->for($event)->create();
        $controller = new EventStageController;
        $response = $controller->destroy($event, $stage);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->status());
        $this->assertNull(Stage::find($stage->id));
    }
}

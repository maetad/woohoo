<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class TenantControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Tenant $tenant;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->tenant = Tenant::factory()->create();
    }

    public function test_it_should_return_pagination_collection()
    {
        $response = $this->actingAs($this->user)
            ->getJson(route('tenants.index'));

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name', 'domains', 'created_at', 'updated_at'],
                ],
                'links',
                'meta'
            ]);
    }

    public function test_it_should_be_created()
    {
        $response = $this->actingAs($this->user)
            ->postJson(
                route('tenants.store'),
                [
                    'name' => 'foo',
                ],
            );

        $response
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure(['id', 'name', 'domains', 'created_at', 'updated_at']);
    }

    public function test_it_should_show()
    {
        $response = $this->actingAs($this->user)
            ->getJson(route('tenants.show', ['tenant' => $this->tenant->id]));

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(['id', 'name', 'domains', 'created_at', 'updated_at']);
    }

    public function test_it_should_not_show_and_return_not_found()
    {
        $response = $this->actingAs($this->user)
            ->getJson(route('tenants.show', ['tenant' => 0]));

        $response
            ->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_it_should_be_updated()
    {
        $response = $this->actingAs($this->user)
            ->putJson(
                route('tenants.update', ['tenant' => $this->tenant->id]),
                [
                    'name' => 'bar',
                ],
                [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
            );

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(['id', 'name', 'domains', 'created_at', 'updated_at']);

        $this->assertNotEquals($this->tenant->name, $response->original->name);
    }

    public function test_it_should_not_be_updated()
    {
        $response = $this->actingAs($this->user)
            ->putJson(
                route('tenants.update', ['tenant' => $this->tenant->id]),
                [],
                [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
            );

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_it_should_be_deleted()
    {
        $response = $this->actingAs($this->user)
            ->deleteJson(route('tenants.destroy', ['tenant' => $this->tenant->id]));

        $response
            ->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertNull(Tenant::find($this->tenant->id));
    }
}

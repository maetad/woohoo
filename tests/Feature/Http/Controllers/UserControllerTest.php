<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\UserController;
use App\Http\Requests\User\IndexRequest;
use App\Http\Requests\User\StoreRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_should_return_pagination_collection()
    {
        /** @var User */
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->getJson(route('users.index'));

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'email', 'name', 'created_at', 'updated_at'],
                ],
                'links',
                'meta'
            ]);
    }

    public function test_it_should_filter_and_return_matched_users()
    {
        /** @var User */
        $user = User::factory()->create(['name' => 'foo']);
        User::factory()->create(['name' => 'fake_bar', 'email' => 'foo@example.com']);
        User::factory()->create(['name' => 'bar']);

        $response = $this->actingAs($user)
            ->getJson(route('users.index', ['keyword' => 'foo']));

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'email', 'name', 'created_at', 'updated_at'],
                ],
                'links',
                'meta'
            ]);

        $this->assertCount(2, $response->original);
    }

    public function test_it_should_be_created()
    {
        /** @var User */
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson(
                route('users.store'),
                [
                    'email' => 'foo@example.com',
                    'password' => 'SuperStrongP@ssw0rd',
                    'name' => 'foo'
                ],
                [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
            );

        $response
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure(['id', 'email', 'name', 'created_at', 'updated_at']);
    }

    public function test_it_should_not_be_created_with_weak_password()
    {
        /** @var User */
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson(
                route('users.store'),
                [
                    'email' => 'foo@example.com',
                    'password' => 'weakpassword',
                    'name' => 'foo'
                ],
                [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
            );

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_it_should_not_be_created_with_wrong_email_pattern()
    {
        /** @var User */
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson(
                route('users.store'),
                [
                    'email' => 'fooexample.com',
                    'password' => 'SuperStrongP@ssw0rd',
                    'name' => 'foo'
                ],
                [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
            );

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_it_should_not_be_created_with_duplicate_email()
    {
        /** @var User */
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson(
                route('users.store'),
                [
                    'email' => $user->email,
                    'password' => 'SuperStrongP@ssw0rd',
                    'name' => 'foo'
                ],
                [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
            );

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_it_should_show()
    {
        /** @var User */
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->getJson(route('users.show', ['user' => $user->id]));

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(['id', 'email', 'name', 'created_at', 'updated_at']);
    }

    public function test_it_should_not_show_and_return_not_found()
    {
        /** @var User */
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->getJson(route('users.show', ['user' => 0]));

        $response
            ->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_it_should_be_updated()
    {
        /** @var User */
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->putJson(
                route('users.update', ['user' => $user->id]),
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
            ->assertJsonStructure(['id', 'email', 'name', 'created_at', 'updated_at']);

        $this->assertNotEquals($user->name, $response->original->name);
        $this->assertEquals($user->password, $response->original->password);
    }

    public function test_it_should_be_updated_and_password_has_been_changed()
    {
        /** @var User */
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->putJson(
                route('users.update', ['user' => $user->id]),
                [
                    'name' => 'bar',
                    'password' => 'NewP@ssw0rd',
                ],
                [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
            );

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(['id', 'email', 'name', 'created_at', 'updated_at']);

        $this->assertNotEquals($user->name, $response->original->name);
        $this->assertNotEquals($user->password, $response->original->password);
    }

    public function test_it_should_not_be_updated()
    {
        /** @var User */
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->putJson(
                route('users.update', ['user' => $user->id]),
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
        /** @var User */
        $user = User::factory()->create();

        /** @var User */
        $target = User::factory()->create();

        $response = $this->actingAs($user)
            ->deleteJson(route('users.destroy', ['user' => $target->id]));

        $response
            ->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertNull(User::find($target->id));
    }

    public function test_it_should_not_be_deleted()
    {
        /** @var User */
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->deleteJson(route('users.destroy', ['user' => $user->id]));

        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }
}

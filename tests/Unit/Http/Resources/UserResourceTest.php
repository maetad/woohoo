<?php

namespace Tests\Unit\Http\Resources;

use App\Http\Resources\UserResource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;

class UserResourceTest extends TestCase
{
    protected User $user;

    public function setUp(): void
    {
        $user = new User;
        $user->setDateFormat('u'); // set date format to prevent database connect

        $user->id = 1;
        $user->name = 'Foo Bar';
        $user->email = 'foo@example.com';
        $user->created_at = Carbon::now();
        $user->updated_at = Carbon::now();

        $this->user = $user;
    }

    public function test_should_return_user_array()
    {
        $resource = new UserResource($this->user);

        $this->assertEquals([
            'id' => $this->user->id,
            'name' => $this->user->name,
            'email' => $this->user->email,
            'created_at' => $this->user->created_at,
            'updated_at' => $this->user->updated_at,
        ], $resource->toArray(new Request));
    }
}

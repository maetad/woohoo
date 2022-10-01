<?php

namespace Tests\Unit\Http\Resources;

use App\Http\Resources\UserCollection;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;

class UserCollectionTest extends TestCase
{
    protected Collection $users;

    public function setUp(): void
    {
        $user = new User;
        $user->setDateFormat('u'); // set date format to prevent database connect

        $user->id = 1;
        $user->name = 'Foo Bar';
        $user->email = 'foo@example.com';
        $user->created_at = Carbon::now();
        $user->updated_at = Carbon::now();

        $this->users = collect([$user]);
    }

    public function test_should_return_array_of_user()
    {
        $collection = new UserCollection($this->users);

        $this->assertEquals([
            [
                'id' => $this->users->first()->id,
                'name' => $this->users->first()->name,
                'email' => $this->users->first()->email,
                'created_at' => $this->users->first()->created_at,
                'updated_at' => $this->users->first()->updated_at,
            ]
        ], $collection->toArray(new Request));
    }
}

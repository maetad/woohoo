<?php

namespace Tests\Unit\Policies;

use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Response as HttpResponse;
use PHPUnit\Framework\TestCase;

class UserPolicyTest extends TestCase
{
    protected User $user;
    protected User $target;
    protected UserPolicy $policy;

    public function setUp(): void
    {
        $this->user = new User;
        $this->user->id = 1;

        $this->target = new User;
        $this->target->id = 2;

        $this->policy = new UserPolicy;
    }

    public function test_it_should_return_allow_when_view_any()
    {
        $this->assertEquals(
            Response::allow(),
            $this->policy->viewAny($this->user, $this->target)
        );
    }

    public function test_it_should_return_allow_when_view()
    {
        $this->assertEquals(
            Response::allow(),
            $this->policy->view($this->user, $this->target)
        );
    }

    public function test_it_should_return_allow_when_create()
    {
        $this->assertEquals(
            Response::allow(),
            $this->policy->create($this->user, $this->target)
        );
    }

    public function test_it_should_return_allow_when_update()
    {
        $this->assertEquals(
            Response::allow(),
            $this->policy->update($this->user, $this->target)
        );
    }

    public function test_it_should_return_allow_when_delete_other_user()
    {
        $this->assertEquals(
            Response::allow(),
            $this->policy->delete($this->user, $this->target)
        );
    }

    public function test_it_should_return_deny_when_delete_current_user()
    {
        $this->target->id = 1;
        $response = $this->policy->delete($this->user, $this->target);

        $this->assertEquals(
            HttpResponse::HTTP_NOT_ACCEPTABLE,
            $response->code()
        );
    }

    public function test_it_should_return_allow_when_restore()
    {
        $this->assertEquals(
            Response::allow(),
            $this->policy->restore($this->user, $this->target)
        );
    }

    public function test_it_should_return_deny_when_force_delete()
    {
        $response = $this->policy->forceDelete($this->user, $this->target);

        $this->assertEquals(
            HttpResponse::HTTP_FORBIDDEN,
            $response->code()
        );
    }
}

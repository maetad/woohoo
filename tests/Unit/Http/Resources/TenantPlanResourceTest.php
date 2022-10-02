<?php

namespace Tests\Unit\Http\Resources;

use App\Http\Resources\TenantPlanResource;
use App\Http\Resources\TenantResource;
use App\Models\Tenant;
use App\Models\TenantPlan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;
use Stancl\Tenancy\Database\Models\Domain;

class TenantPlanResourceTest extends TestCase
{
    protected TenantPlan $plan;

    public function setUp(): void
    {
        $plan = new TenantPlan;
        $plan->setDateFormat('u'); // set date format to prevent database connect

        $plan->id = 1;
        $plan->name = 'free';
        $plan->created_at = Carbon::now();
        $plan->updated_at = Carbon::now();

        $this->plan = $plan;
    }

    public function test_should_return_plan_array()
    {
        $resource = new TenantPlanResource($this->plan);

        $this->assertEquals([
            'id' => $this->plan->id,
            'name' => $this->plan->name,
            'data' => $this->plan->data,
            'created_at' => $this->plan->created_at,
            'updated_at' => $this->plan->updated_at,
        ], $resource->toArray(new Request));
    }
}

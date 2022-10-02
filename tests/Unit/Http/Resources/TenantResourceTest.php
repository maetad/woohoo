<?php

namespace Tests\Unit\Http\Resources;

use App\Http\Resources\TenantResource;
use App\Models\Tenant;
use App\Models\TenantPlan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use PHPUnit\Framework\TestCase;
use Stancl\Tenancy\Database\Models\Domain;

class TenantResourceTest extends TestCase
{
    protected Tenant $tenant;

    public function setUp(): void
    {
        $tenant = new Tenant;
        $tenant->setDateFormat('u'); // set date format to prevent database connect

        $tenant->id = 'uuid';
        $tenant->name = 'Foo Bar';
        $tenant->created_at = Carbon::now();
        $tenant->updated_at = Carbon::now();
        $tenant->domains = collect(new Domain);
        $tenant->plan = new TenantPlan;

        $this->tenant = $tenant;
    }

    public function test_should_return_tenant_array()
    {
        $resource = new TenantResource($this->tenant);
        $resource = $resource->toArray(new Request);

        $this->assertEquals($this->tenant->id, $resource['id']);
        $this->assertEquals($this->tenant->name, $resource['name']);
        $this->assertInstanceOf(AnonymousResourceCollection::class, $resource['domains']);
        $this->assertEquals($this->tenant->created_at, $resource['created_at']);
        $this->assertEquals($this->tenant->updated_at, $resource['updated_at']);
    }
}

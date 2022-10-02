<?php

namespace Tests\Unit\Http\Resources;

use App\Http\Resources\TenantCollection;
use App\Models\Tenant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;

class TenantCollectionTest extends TestCase
{
    protected Collection $tenants;

    public function setUp(): void
    {
        $tenant = new Tenant;
        $tenant->setDateFormat('u'); // set date format to prevent database connect

        $tenant->id = 'uuid';
        $tenant->name = 'Foo Bar';
        $tenant->created_at = Carbon::now();
        $tenant->updated_at = Carbon::now();
        $tenant->domains = collect([]);

        $this->tenants = collect([$tenant]);
    }

    public function test_should_return_array_of_tenant()
    {
        $collection = new TenantCollection($this->tenants);
        $collection = $collection->toArray(new Request);

        $this->assertCount(1, $collection);

        $this->assertEquals($this->tenants->first()->id, $collection[0]['id']);
        $this->assertEquals($this->tenants->first()->name, $collection[0]['name']);
        $this->assertInstanceOf(AnonymousResourceCollection::class, $collection[0]['domains']);
        $this->assertEquals($this->tenants->first()->created_at, $collection[0]['created_at']);
        $this->assertEquals($this->tenants->first()->updated_at, $collection[0]['updated_at']);
    }
}

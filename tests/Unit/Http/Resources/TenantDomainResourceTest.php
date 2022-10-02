<?php

namespace Tests\Unit\Http\Resources;

use App\Http\Resources\TenantDomainResource;
use App\Http\Resources\TenantResource;
use App\Models\Tenant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;
use Stancl\Tenancy\Database\Models\Domain;

class TenantDomainResourceTest extends TestCase
{
    protected Domain $domain;

    public function setUp(): void
    {
        $domain = new Domain;
        $domain->setDateFormat('u'); // set date format to prevent database connect

        $domain->id = 1;
        $domain->domain = 'localhost';
        $domain->created_at = Carbon::now();
        $domain->updated_at = Carbon::now();
        $domain->tenant = new Tenant;

        $this->domain = $domain;
    }

    public function test_should_return_domain_array()
    {
        $resource = new TenantDomainResource($this->domain);
        $resource = $resource->toArray(new Request);

        $this->assertEquals($this->domain->id, $resource['id']);
        $this->assertEquals($this->domain->domain, $resource['domain']);
        $this->assertInstanceOf(TenantResource::class, $resource['tenant']);
        $this->assertEquals($this->domain->created_at, $resource['created_at']);
        $this->assertEquals($this->domain->updated_at, $resource['updated_at']);
    }
}

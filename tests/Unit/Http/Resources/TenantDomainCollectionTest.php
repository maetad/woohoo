<?php

namespace Tests\Unit\Http\Resources;

use App\Http\Resources\TenantDomainCollection;
use App\Http\Resources\TenantResource;
use App\Models\Tenant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;
use Stancl\Tenancy\Database\Models\Domain;

class TenantDomainCollectionTest extends TestCase
{
    protected Collection $domains;

    public function setUp(): void
    {
        $domain = new Domain;
        $domain->setDateFormat('u'); // set date format to prevent database connect

        $domain->id = 1;
        $domain->domain = 'localhost';
        $domain->created_at = Carbon::now();
        $domain->updated_at = Carbon::now();
        $domain->setRelations([
            'tenant' => new Tenant,
        ]);

        $this->domains = collect([$domain]);
    }

    public function test_should_return_array_of_domain()
    {
        $collection = new TenantDomainCollection($this->domains);

        $this->assertEquals([
            [
                'id' => $this->domains->first()->id,
                'domain' => $this->domains->first()->domain,
                'tenant' => new TenantResource($this->domains->first()->tenant),
                'created_at' => $this->domains->first()->created_at,
                'updated_at' => $this->domains->first()->updated_at,
            ]
        ], $collection->toArray(new Request));
    }
}

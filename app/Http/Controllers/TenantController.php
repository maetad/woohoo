<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tenant\IndexRequest;
use App\Http\Requests\Tenant\StoreRequest;
use App\Http\Requests\Tenant\UpdateRequest;
use App\Http\Resources\TenantResource;
use App\Models\Tenant;
use App\Models\TenantPlan;

class TenantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param IndexRequest $request
     * @return \App\Http\Resources\TenantCollection
     */
    public function index(IndexRequest $request)
    {
        $tenants = Tenant::paginate($request->input('per_page', 15));
        return TenantResource::collection($tenants);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreRequest  $request
     * @return TenantResource
     */
    public function store(StoreRequest $request)
    {
        $plan = TenantPlan::default()->first();

        $tenant = new Tenant([
            ...$request->only(['name']),
        ]);

        $tenant->plan()->associate($plan);
        $tenant->save();

        return new TenantResource($tenant);
    }

    /**
     * Display the specified resource.
     *
     * @param  Tenant  $tenant
     * @return TenantResource
     */
    public function show(Tenant $tenant)
    {
        return new TenantResource($tenant);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest  $request
     * @param  Tenant  $tenant
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Tenant $tenant)
    {
        $tenant->update($request->only(['name']));

        return new TenantResource($tenant);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Tenant  $tenant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tenant $tenant)
    {
        $tenant->delete();
        return response()->noContent();
    }
}

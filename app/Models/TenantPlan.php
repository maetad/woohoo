<?php

namespace App\Models;

use App\Models\Scopes\TenantPlanActive;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TenantPlan extends Model
{
    use HasFactory;

    protected $casts = [
        'data' => 'json',
        'is_default' => 'boolean',
        'is_recommended' => 'boolean',
    ];

    protected $dates = ['active_at', 'expired_at'];

    protected static function booted()
    {
        static::addGlobalScope(new TenantPlanActive);
    }

    public function scopeDefault(Builder $builder)
    {
        $builder->where('is_default', true);
    }

    public function tenant(): HasMany
    {
        return $this->hasMany(Tenant::class, 'plan_id');
    }
}

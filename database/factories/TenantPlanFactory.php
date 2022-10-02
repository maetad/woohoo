<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tenant>
 */
class TenantPlanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->company(),
            'amount' => (int)floor(fake()->randomFloat() * 100),
            'currency' => 'THB',
            'active_at' => Carbon::now(),
            'expired_at' => Carbon::now()->addYear(),
        ];
    }
}

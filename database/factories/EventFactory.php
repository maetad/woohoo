<?php

namespace Database\Factories;

use App\Casts\EventDateCast;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->streetName(),
            'detail' => $this->faker->sentence(),
            'status' => 'initiate',
            'dates' => collect([
                new EventDateCast($this->faker->iso8601, $this->faker->iso8601)
            ])
        ];
    }
}

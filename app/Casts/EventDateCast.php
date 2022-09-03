<?php

namespace App\Casts;

use App\Serializers\EventDateSerializer;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class EventDateCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function get($model, string $key, $value, array $attributes)
    {
        return collect(json_decode($value, true))
            ->map(
                fn ($date) => new EventDateSerializer($date['start'] ?? null, $date['end'] ?? null)
            );
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return string
     */
    public function set($model, string $key, $value, array $attributes)
    {
        return json_encode($value);
    }
}

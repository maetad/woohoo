<?php

namespace App\Models;

use App\Casts\EventDateCast;
use App\Enums\EventStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Wildside\Userstamps\Userstamps;

class Event extends Model
{
    use HasFactory;
    use Userstamps;

    protected $casts = [
        'dates' => EventDateCast::class,
        'status' => EventStatus::class,
    ];

    /**
     * Stage relationship
     *
     * @return HasMany
     */
    public function stages(): HasMany
    {
        return $this->hasMany(Stage::class);
    }
}

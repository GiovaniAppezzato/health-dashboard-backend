<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'sleep_hours',
    'glucose_level',
    'heart_rate',
    'water_intake',
    'measured_at',
])]
class HealthSnapshot extends Model
{
    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'sleep_hours'   => 'decimal:2',
            'glucose_level' => 'integer',
            'heart_rate'    => 'integer',
            'water_intake'  => 'integer',
            'measured_at'   => 'datetime',
        ];
    }

    public function recommendations(): HasMany
    {
        return $this->hasMany(Recommendation::class);
    }
}

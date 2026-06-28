<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'health_snapshot_id',
    'position',
    'content',
])]
class Recommendation extends Model
{
    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'position' => 'integer',
        ];
    }

    public function healthSnapshot(): BelongsTo
    {
        return $this->belongsTo(HealthSnapshot::class);
    }
}

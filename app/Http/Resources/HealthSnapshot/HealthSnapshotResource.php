<?php

namespace App\Http\Resources\HealthSnapshot;

use App\Http\Resources\Recommendation\RecommendationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HealthSnapshotResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'glucose_level'   => $this->glucose_level,
            'heart_rate'      => $this->heart_rate,
            'sleep_hours'     => (float) $this->sleep_hours,
            'water_intake'    => (float) $this->water_intake,
            'measured_at'     => $this->measured_at->format('Y-m-d'),
            'recommendations' => RecommendationResource::collection($this->recommendations),
        ];
    }
}

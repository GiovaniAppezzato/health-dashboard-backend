<?php

namespace App\Http\Resources\Recommendation;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecommendationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                 => $this->id,
            'health_snapshot_id' => $this->health_snapshot_id,
            'position'           => $this->position,
            'content'            => $this->content,
        ];
    }
}

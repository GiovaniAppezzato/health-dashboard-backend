<?php

namespace App\Repositories\Recommendation;

use App\DTOs\RecommendationDTO;
use App\Models\Recommendation;

class RecommendationRepository
{
    public function __construct(
        protected Recommendation $model
    ) {}

    public function save(RecommendationDTO $recommendationDTO): Recommendation
    {
        return $this->model->create($recommendationDTO->toArray());
    }
}

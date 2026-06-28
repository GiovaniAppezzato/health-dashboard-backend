<?php

namespace App\Repositories\Recommendation;

use App\Models\Recommendation;

class RecommendationRepository
{
    public function __construct(
        protected Recommendation $model
    ) {}
}

<?php

namespace App\Services\Recommendation;

use App\Repositories\Recommendation\RecommendationRepository;

class RecommendationService
{
    public function __construct(
        protected RecommendationRepository $repository,
    ) {}
}

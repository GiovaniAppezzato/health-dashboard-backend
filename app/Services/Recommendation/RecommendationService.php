<?php

namespace App\Services\Recommendation;

use App\Models\Recommendation;
use App\Models\HealthSnapshot;
use App\DTOs\RecommendationDTO;
use App\Repositories\Recommendation\RecommendationRepository;
use Illuminate\Support\Collection;

class RecommendationService
{
    public function __construct(
        protected RecommendationRepository $repository,
    ) {}

    public function generateFakeRecommendations(HealthSnapshot $healthSnapshot): void
    {
        $recommendations = [
            'Priorize uma rotina de sono consistente para melhorar sua recuperação diária.',
            'Mantenha refeições equilibradas ao longo do dia para ajudar no controle da glicose.',
            'Inclua pausas curtas para hidratação e movimento leve durante sua rotina.',
        ];

        collect($recommendations)
            ->map(function (string $content, int $index) use ($healthSnapshot): Recommendation {
                return $this->repository->save(new RecommendationDTO(
                    health_snapshot_id: $healthSnapshot->id,
                    position: $index + 1,
                    content: $content,
                ));
            });
    }
}

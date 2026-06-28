<?php

namespace App\Services\HealthSnapshot;

use App\Models\HealthSnapshot;
use App\DTOs\HealthSnapshotDTO;
use App\Repositories\HealthSnapshot\HealthSnapshotRepository;
use App\Services\Recommendation\RecommendationService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class HealthSnapshotService
{
    public function __construct(
        protected HealthSnapshotRepository $repository,
        protected RecommendationService $recommendationService
    ) {}

    public function list(): LengthAwarePaginator
    {
        return $this->repository->list();
    }

    public function find(int $healthSnapshotId): ?HealthSnapshot
    {
        return $this->repository->find($healthSnapshotId);
    }

    public function findByMeasuredAt(string $measuredAt): ?HealthSnapshot
    {
        return $this->repository->findByMeasuredAt($measuredAt);
    }

    public function latest(): ?HealthSnapshot
    {
        return $this->repository->latest();
    }

    public function save(HealthSnapshotDTO $healthSnapshotDTO): HealthSnapshot
    {
        $healthSnapshot = $this->repository->save($healthSnapshotDTO);

        $this->recommendationService->generateFakeRecommendations($healthSnapshot);

        $healthSnapshot->load('recommendations');

        return $healthSnapshot;
    }
}

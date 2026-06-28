<?php

namespace App\Services\HealthSnapshot;

use App\Models\HealthSnapshot;
use App\DTOs\HealthSnapshotDTO;
use App\Repositories\HealthSnapshot\HealthSnapshotRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class HealthSnapshotService
{
    public function __construct(
        protected HealthSnapshotRepository $repository,
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
        return $this->repository->save($healthSnapshotDTO);
    }
}

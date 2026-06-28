<?php

namespace App\Repositories\HealthSnapshot;

use App\Models\HealthSnapshot;
use App\DTOs\HealthSnapshotDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class HealthSnapshotRepository
{
    public function __construct(
        protected HealthSnapshot $model
    ) {}

    public function list(): LengthAwarePaginator
    {
        return $this->model->query()
            ->with('recommendations')
            ->orderByDesc('measured_at')
            ->paginate();
    }

    public function find(int $healthSnapshotId): ?HealthSnapshot
    {
        return $this->model->query()
            ->with('recommendations')
            ->find($healthSnapshotId);
    }

    public function findByMeasuredAt(string $measuredAt): ?HealthSnapshot
    {
        return $this->model->query()
            ->with('recommendations')
            ->whereDate('measured_at', $measuredAt)
            ->first();
    }

    public function latest(): ?HealthSnapshot
    {
        return $this->model->query()
            ->with('recommendations')
            ->latest('measured_at')
            ->first();
    }

    public function save(HealthSnapshotDTO $healthSnapshotDTO): HealthSnapshot
    {
        return $this->model->create($healthSnapshotDTO->toArray());
    }

    public function delete(int $healthSnapshotId): void
    {
        $this->model->destroy($healthSnapshotId);
    }
}

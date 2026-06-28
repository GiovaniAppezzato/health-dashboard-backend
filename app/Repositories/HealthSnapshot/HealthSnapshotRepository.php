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
        return $this->model->paginate();
    }

    public function find(int $healthSnapshotId): ?HealthSnapshot
    {
        return $this->model->find($healthSnapshotId);
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

<?php

namespace App\Services\HealthSnapshot;

use App\Repositories\HealthSnapshot\HealthSnapshotRepository;

class HealthSnapshotService
{
    public function __construct(
        protected HealthSnapshotRepository $repository,
    ) {}
}

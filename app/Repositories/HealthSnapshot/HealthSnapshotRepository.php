<?php

namespace App\Repositories\HealthSnapshot;

use App\Models\HealthSnapshot;

class HealthSnapshotRepository
{
    public function __construct(
        protected HealthSnapshot $model
    ) {}
}

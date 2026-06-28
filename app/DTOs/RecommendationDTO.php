<?php

namespace App\DTOs;

class RecommendationDTO extends AbstractDTO
{
    public function __construct(
        public readonly ?int $health_snapshot_id,
        public readonly ?int $position,
        public readonly ?string $content,
        public readonly ?int $id = null,
    ) {}
}

<?php

namespace App\DTOs;

class HealthSnapshotDTO extends AbstractDTO
{
    public function __construct(
        public readonly ?int $sleep_hours,
        public readonly ?int $glucose_level,
        public readonly ?int $heart_rate,
        public readonly ?float $water_intake,
        public readonly ?string $measured_at,
        public readonly ?int $id,
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            id:            data_get($data, 'id', null),
            sleep_hours:   data_get($data, 'sleep_hours'),
            glucose_level: data_get($data, 'glucose_level'),
            heart_rate:    data_get($data, 'heart_rate'),
            water_intake:  data_get($data, 'water_intake'),
            measured_at:   data_get($data, 'measured_at'),
        );
    }
}

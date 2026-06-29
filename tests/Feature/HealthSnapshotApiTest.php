<?php

namespace Tests\Feature;

use App\Models\HealthSnapshot;
use App\Models\Recommendation;
use App\Services\AI\HealthRecommendationGenerator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\MockInterface;
use Tests\TestCase;

class HealthSnapshotApiTest extends TestCase
{
    use RefreshDatabase;

    private const DEFAULT_FIELDS = [
        'sleep_hours'   => 8,
        'glucose_level' => 115,
        'heart_rate'    => 78,
        'water_intake'  => 2.5,
    ];

    private const MOCK_RECOMMENDATIONS = [
        'Priorize uma rotina de sono consistente.',
        'Mantenha refeições equilibradas ao longo do dia.',
        'Inclua pausas curtas para hidratação.',
    ];

    public function test_lists_snapshots_ordered_by_most_recent(): void
    {
        $this->createSnapshot(measuredAt: '2026-06-28');
        $this->createSnapshot(measuredAt: '2026-06-27');

        $this->getJson('/api/health-snapshots')
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonPath('data.0.measured_at', '2026-06-28')
            ->assertJsonPath('data.1.measured_at', '2026-06-27');
    }

    public function test_shows_snapshot_with_its_recommendations(): void
    {
        $snapshot = $this->createSnapshot(measuredAt: '2026-06-28');

        $this->getJson("/api/health-snapshots/{$snapshot->id}")
            ->assertOk()
            ->assertJson(['id' => $snapshot->id, 'measured_at' => '2026-06-28', ...self::DEFAULT_FIELDS])
            ->assertJsonCount(3, 'recommendations');
    }

    public function test_shows_the_latest_snapshot(): void
    {
        $this->createSnapshot(measuredAt: '2026-06-27');
        $latest = $this->createSnapshot(measuredAt: '2026-06-28');

        $this->getJson('/api/health-snapshots/latest')
            ->assertOk()
            ->assertJsonPath('id', $latest->id)
            ->assertJsonPath('measured_at', '2026-06-28');
    }

    public function test_creates_snapshot_and_generates_recommendations(): void
    {
        $this->mockRecommendationGenerator();

        $today = now()->toDateString();

        $this->postJson('/api/health-snapshots', ['measured_at' => $today, ...self::DEFAULT_FIELDS])
            ->assertCreated()
            ->assertJson(['measured_at' => $today, ...self::DEFAULT_FIELDS])
            ->assertJsonCount(3, 'recommendations');

        $this->assertDatabaseHas('health_snapshots', [
            'measured_at' => "{$today} 00:00:00",
            ...self::DEFAULT_FIELDS,
        ]);

        $this->assertDatabaseCount('recommendations', 3);
    }

    public function test_rejects_duplicate_measured_at(): void
    {
        $this->createSnapshot(measuredAt: now()->toDateString(), withRecommendations: false);

        $this->postJson('/api/health-snapshots', ['measured_at' => now()->toDateString(), ...self::DEFAULT_FIELDS])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('measured_at');
    }

    public function test_rejects_future_measured_at(): void
    {
        $this->postJson('/api/health-snapshots', ['measured_at' => now()->addDay()->toDateString(), ...self::DEFAULT_FIELDS])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('measured_at');
    }

    public function test_rejects_empty_payload(): void
    {
        $this->postJson('/api/health-snapshots', [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['sleep_hours', 'glucose_level', 'heart_rate', 'water_intake', 'measured_at']);
    }

    public function test_deletes_snapshot(): void
    {
        $snapshot = $this->createSnapshot();

        $this->deleteJson("/api/health-snapshots/{$snapshot->id}")
            ->assertNoContent();

        $this->assertDatabaseMissing('health_snapshots', ['id' => $snapshot->id]);
    }

    private function createSnapshot(
        string $measuredAt = '2026-06-28',
        bool $withRecommendations = true,
        array $fields = [],
    ): HealthSnapshot {
        $snapshot = HealthSnapshot::query()->create([
            'measured_at' => $measuredAt,
            ...self::DEFAULT_FIELDS,
            ...$fields,
        ]);

        if ($withRecommendations) {
            foreach (range(1, 3) as $position) {
                Recommendation::query()->create([
                    'health_snapshot_id' => $snapshot->id,
                    'position'           => $position,
                    'content'            => "Recomendação {$position}",
                ]);
            }
        }

        return $snapshot;
    }

    private function mockRecommendationGenerator(): void
    {
        $this->mock(
            HealthRecommendationGenerator::class,
            fn (MockInterface $mock) => $mock
                ->shouldReceive('handle')
                ->once()
                ->andReturn(self::MOCK_RECOMMENDATIONS)
        );
    }
}

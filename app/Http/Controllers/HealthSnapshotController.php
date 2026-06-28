<?php

namespace App\Http\Controllers;

use App\Models\HealthSnapshot;
use App\DTOs\HealthSnapshotDTO;
use App\Services\HealthSnapshot\HealthSnapshotService;
use App\Http\Resources\HealthSnapshot\HealthSnapshotResource;
use App\Http\Requests\HealthSnapshot\StoreHealthSnapshotRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class HealthSnapshotController extends Controller
{
    public function __construct(
        protected HealthSnapshotService $service
    ) {}

    public function index(): AnonymousResourceCollection
    {
        $helthSnapshots = $this->service->list();

        return HealthSnapshotResource::collection($helthSnapshots);
    }

    public function show(int $id): HealthSnapshotResource
    {
        $healthSnapshot = $this->service->find($id);

        return new HealthSnapshotResource($healthSnapshot);
    }

    public function latest(): HealthSnapshotResource
    {
        $healthSnapshot = $this->service->latest();

        return new HealthSnapshotResource($healthSnapshot);
    }

    public function store(StoreHealthSnapshotRequest $request): HealthSnapshotResource
    {
        $healthSnapshotDTO = HealthSnapshotDTO::fromRequest($request->validated());

        $healthSnapshot = $this->service->save($healthSnapshotDTO);

        return new HealthSnapshotResource($healthSnapshot);
    }

    public function destroy(HealthSnapshot $healthSnapshot): Response
    {
        $healthSnapshot->delete();

        return response()->noContent();
    }
}

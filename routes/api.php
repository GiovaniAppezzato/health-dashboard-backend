<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestConnectionController;
use App\Http\Controllers\HealthSnapshotController;

Route::get('/test-connection', TestConnectionController::class);

Route::get('health-snapshots/latest', [HealthSnapshotController::class, 'latest']);
Route::apiResource('health-snapshots', HealthSnapshotController::class)->except('update');

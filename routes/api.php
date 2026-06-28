<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestConnectionController;
use App\Http\Controllers\HealthSnapshotController;

Route::get('/test-connection', TestConnectionController::class);

Route::apiResource('health-snapshots', HealthSnapshotController::class)->except('update');

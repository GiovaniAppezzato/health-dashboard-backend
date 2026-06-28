<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestConnectionController;

Route::get('/test-connection', TestConnectionController::class);

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\LoteriaController;
use App\Http\Controllers\Api\V1\HorarioController;
use App\Http\Controllers\Api\V1\FuenteScraperController;

Route::prefix('v1')->group(function () {
    Route::apiResource('lotteries', LoteriaController::class);
    Route::post('lotteries/{id}/restore', [LoteriaController::class, 'restore']);

    Route::apiResource('schedules', HorarioController::class);
    Route::post('schedules/{id}/restore', [HorarioController::class, 'restore']);

    Route::apiResource('scraping-sources', FuenteScraperController::class);
    Route::post('scraping-sources/{id}/restore', [FuenteScraperController::class, 'restore']);
});


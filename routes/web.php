<?php

use App\Http\Controllers\DemoController;
use App\Http\Controllers\ImageController;

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ImageProcessingController;

Route::post('/process-image', [ImageProcessingController::class, 'processImage'])->name('process.image');

Route::get('/', function () {
    return view('demo');
});

Route::POST('/demo', [DemoController::class, 'showText'])->name('ajax.gemini');

// Route::POST('/img', [ImageController::class, 'showText'])->name('ajax.gemini.capture');
// Route::post('/process-image', [ImageProcessingController::class, 'processImage'])->name('process.image');
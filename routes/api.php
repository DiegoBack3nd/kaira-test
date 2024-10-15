<?php

use App\Http\Controllers\ShortUrlController;
use App\Http\Middleware\AccessTokenMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware([AccessTokenMiddleware::class])->group(function () {
    Route::post('/v1/short-urls', [ShortUrlController::class, 'generateShortUrl']);
});

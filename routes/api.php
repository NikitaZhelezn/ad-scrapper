<?php

use App\Http\Controllers\Api\PageSubscribeController;
use Illuminate\Support\Facades\Route;

Route::group(['as' => 'api.'], function () {
    Route::post('page/subscribe', [PageSubscribeController::class, 'store']);

    Route::delete('page/unsubscribe', [PageSubscribeController::class, 'delete']);
});

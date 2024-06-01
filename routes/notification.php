<?php

use App\Http\Controllers\Api\V1\Notification\NotificationController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'notification'], function () {
    Route::get('index', [NotificationController::class, 'index'])->name('notification.index');
    Route::get('user-notifications', [NotificationController::class, 'userNotifications']);
    Route::post('store', [NotificationController::class, 'store'])->name('notification.store');
    Route::get('get-notifables/{type}', [NotificationController::class, 'getNotifables']);
});

<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Client\NotificationResource;
use App\Traits\ApiResponseTrait;

class NotificationsController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        return $this->respondWithCollection(
            NotificationResource::collection(auth('api')->user()->notifications)
        );
    }

    public function readNotification($id)
    {
        $notification = auth('api')->user()->notifications()->find($id);
        if ($notification) {
            $notification->markAsRead();
        }
        return response()->json(
            ['data' => NotificationResource::make($notification)]
        );
    }

    public function readAllNotifications()
    {
        $notifications = auth('api')->user()->notifications;
        if ($notifications) {
            $notifications->markAsRead();
        }
        return response()->json(
            ['data' => NotificationResource::collection($notifications)]
        );
    }

}

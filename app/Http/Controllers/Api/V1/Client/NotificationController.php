<?php

namespace App\Http\Controllers\Api\V1\Client;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Http\Resources\Api\V1\Client\{NotificationResource};

class NotificationController extends Controller
{

    public function showNotifications(){
     $notifications=Notification::where('notifiable_id',auth('api')->user()->id)->latest('created_at')->get();
     $collection = NotificationResource::collection($notifications)->customPaginate(20);
     return $collection;
     
    }






}

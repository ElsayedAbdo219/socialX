<?php

namespace App\Http\Controllers\Api\V1\Client;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Http\Resources\Api\V1\Client\{NotificationResource};

class NotificationController extends Controller
{

    public function showNotifications(Request $request)
    {
        $paginateSize = $request->query('paginateSize', 20);
        $user = auth('api')->user();
        
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return  Notification::where('notifiable_id', $user->id)->latest('created_at')->paginate($paginateSize);
    }

    public function markAsRead(Request $request, $id)
    {
        $user = auth('api')->user();
        
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $notification = Notification::where('notifiable_id', $user->id)->findOrFail($id);
        $notification->markAsRead();
        
        return response()->json(['message' => 'تم تحديث الإشعار بنجاح'], 200);
    }
    public function countNotifications()
    {
      return 
      [
        'all-Notifications' => Notification::where('notifiable_id', auth('api')->id())->count(),
        'unread-Notifications' => Notification::where('notifiable_id', auth('api')->id())->where('read_at', null)->count(),
        'read-Notifications' => Notification::where('notifiable_id', auth('api')->id())->whereNotNull('read_at')->count(),
      ];
    }


}

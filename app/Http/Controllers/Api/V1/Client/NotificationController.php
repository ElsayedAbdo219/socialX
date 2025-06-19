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
        // Get the pagination size from the request, default to 20
        $paginateSize = $request->query('paginateSize', 20);
        
        // Get the authenticated user
        $user = auth('api')->user();
        
        // Ensure the user is authenticated
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        // Get notifications for the authenticated user
        return  Notification::where('notifiable_id', $user->id)->latest('created_at')->paginate($paginateSize);
        
        // Transform the notifications using a resource collection
        // return NotificationResource::collection($notifications);
    }
  


    public function markAsRead(Request $request, $id)
    {
        $user = auth('api')->user();
        
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        // Find the notification by ID and mark it as read
        $notification = Notification::where('notifiable_id', $user->id)->findOrFail($id);
        $notification->markAsRead();
        
        return response()->json(['message' => 'تم تحديث الإشعار بنجاح'], 200);
    }


}

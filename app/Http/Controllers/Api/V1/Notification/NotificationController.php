<?php

namespace App\Http\Controllers\Api\V1\Notification;

use App\Enum\UserTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Notification\SendNotificationRequest;
use App\Http\Resources\Api\Notification\NotificationResource;
use App\Http\Resources\Api\V1\Dashboard\UserResource;
use App\Notifications\AdminNotification;
use App\Notifications\DashboardNotification;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{
    use ApiResponseTrait;

    protected mixed $modelResource = NotificationResource::class;

   /*  public function __construct(protected UserContract $userRepository)
    {
        $this->middleware(['role_or_permission:notifications-index|' . activeGuard()])->only(['__invoke', 'index']);
        $this->middleware(['role_or_permission:notifications-create|' . activeGuard()])->only('store');
    } */

    public function index(Request $request): mixed
    {
        $request->validate(['unread' => 'nullable|boolean']);
        $notifications = \App\Models\Notification::with('notifiable')
            ->where('type', get_class(new DashboardNotification()))
            ->when($request->has('title'), function ($query) use ($request) {
                $name = 'data';
                $query->whereRaw("JSON_VALID({$name}) AND JSON_EXTRACT({$name}, '$.title.ar') like '%{$request->title}%'")
                    ->orWhereRaw("JSON_VALID({$name}) AND lower(JSON_EXTRACT({$name}, '$.title.en')) like '%{$request->title}%'");
            })->when($request->has('sendType'), function ($query) use ($request) {
                $query->whereHas('notifiable', function ($query) use ($request) {
                    $name = 'data';
                    $query->whereRaw("JSON_VALID({$name}) AND JSON_EXTRACT({$name}, '$.anotherData.notify_type') like '%{$request->sendType}%'");
                });
            })->when($request->has('unread'), function ($query) use ($request) {
                $query->whereNull('read_at');
            })->get();

        return $this->respondWithCollection(NotificationResource::collection($notifications));
    }

    public function userNotifications()
    {
        $notifications = auth('api')->user()->notifications()
            ->with(['notifiable'])
            ->where('type', '!=', get_class(new DashboardNotification()))
            ->get();
        return $this->respondWithCollection(NotificationResource::collection($notifications));
    }

    /**
     * List Notification
     *
     * an API which Offers a mean to list notifications
     * @authenticated
     * @header Api-Key xx
     * @header Api-Version v1
     * @header Accept-Language ar
     */
    protected function store(SendNotificationRequest $request)
    {
        $notificationData = [
            'title' => json_encode(['en' => $request->title_en, 'ar' => $request->title_ar]),
            'body' => json_encode(
                [
                    'data' => $request->body,
                    'anotherData' => [
                        'type' => 'send_notification',
                        'id' => null,
                        'notify_type' => 'admin',
                    ]
                ]
            ),
        ];

        if (!empty($request->ids)) {
            $notifabels = $this->userRepository->search(
                filters: ['id' => $request->ids, 'status' => true],
                page: 0,
                limit: 0
            );
        } else {
            $type = [$request->type];
            if ($request->type == 'all') {
                $type = [UserTypeEnum::SUPPLIER, UserTypeEnum::CLIENT, UserTypeEnum::COMPANY];
            }
            $notifabels = $this->userRepository->search(
                filters: ['type' => $type, 'status' => true],
                page: 0,
                limit: 0
            );
        }
        Notification::send($notifabels, new DashboardNotification($notificationData, ['database', 'firebase']));

        return $this->respondWithSuccess(__('Notification Sent Successfully'));
    }


    public function getNotifables($type)
    {
        $notifabelType = [$type];
        if ($type == 'all') {
            $notifabelType = [UserTypeEnum::SUPPLIER, UserTypeEnum::CLIENT, UserTypeEnum::COMPANY];
        }

        $notifabels = $this->userRepository->search(
            filters: ['type' => $notifabelType, 'status' => true],
            page: 0,
            limit: 0
        );
        return $this->respondWithCollection(UserResource::collection($notifabels));
    }
}

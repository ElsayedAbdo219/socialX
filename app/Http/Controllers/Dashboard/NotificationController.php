<?php

namespace App\Http\Controllers\Dashboard;

use App\Datatables\NotificationDatatable;
use App\Enum\MerchantCodingStatusEnum;
use App\Enum\UserTypeEnum;
use App\Models\Notification;
use App\Models\User;
use App\Notifications\DashboardNotification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MerchantCategory;
use App\Models\MerchantInfo;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NotificationController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    protected string $datatable = NotificationDatatable::class;
    protected string $routeName = 'admin.notification';
    protected string $viewPath = 'dashboard.notification.list';
    public function index()
    {
        return $this->datatable::create($this->routeName)
            ->render($this->viewPath);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types['all'] = __('all');
        return view('dashboard.notification.add',compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string'],
            'body' => ['required', 'string'],
        ]);
        
        $notificationData = [
            'title' => $validated['title']  ,
            'body' => $validated['body']  ,
        ];
        
        // Fetch user IDs from the database
        $merchantIds = User::where('is_active', 1)->pluck('id');
        
        // Fetch users with the IDs retrieved above
        $notifiables = User::whereIn('id', $merchantIds)->get();
       
        
        // Send notifications to the retrieved users
        \Illuminate\Support\Facades\Notification::send($notifiables,
            new DashboardNotification($notificationData, ['database', 'firebase']));
        
        return redirect()->route('admin.notification.index')->with('success', __('dashboard.notifications_sent_successfully'));
        

    }

    /**
     * Display the specified resource.
     */
    public function show(Notification $notification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notification $notification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notification $notification)
    {
        //
    }

    public function markAsRead(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();
        return redirect()->route('admin.home');
    }
}

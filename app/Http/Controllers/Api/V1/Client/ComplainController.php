<?php

namespace App\Http\Controllers\Api\V1\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Models\Complain;
use App\Notifications\DashboardNotification;
use App\Models\User;
class ComplainController extends Controller
{
    use ApiResponseTrait;

    public function send(Request $request){

    $request->validate([ "message"=>"required"]);

    $complain=Complain::create(["message"=>$request->message]);
    

    $notifabel = User::whereType('admin')->first();
    
    $notificationData = [
      'title' => __('dashboard.complain_send_from') . ' '. $complain->user->name,
      'body' => $complain->message,
    ];
   // return $notificationData;
    # sending a notification to the user
    \Illuminate\Support\Facades\Notification::send($notifabel,
    new DashboardNotification($notificationData, ['database', 'firebase']));
      

    return $this->respondWithSuccess(__('messages.Complain added successfully'));

    }
}

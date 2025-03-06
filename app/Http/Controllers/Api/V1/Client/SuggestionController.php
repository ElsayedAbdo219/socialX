<?php

namespace App\Http\Controllers\Api\V1\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Models\Suggestion;
use App\Notifications\DashboardNotification;
use App\Models\User;
class SuggestionController extends Controller
{
    use ApiResponseTrait;

    public function send(Request $request){

    $request->validate([ "message"=>"required|string"]);

    $Suggestion=Suggestion::create(["message"=>$request->message]);
    

    $notifabel = User::whereType('admin')->first();
    
    $notificationData = [
      'title' => __('dashboard.Suggestion_send_from') . ' '. $Suggestion->user->name,
      'body' => $Suggestion->message,
    ];
   // return $notificationData;
    # sending a notification to the user
    \Illuminate\Support\Facades\Notification::send($notifabel,
    new DashboardNotification($notificationData, ['database', 'firebase']));
      

    return $this->respondWithSuccess(__('messages.Suggestion added successfully'));

    }
}

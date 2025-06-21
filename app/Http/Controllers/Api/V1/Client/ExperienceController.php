<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Models\Member;
use App\Enum\UserTypeEnum;
use App\Models\Experience;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Notifications\ClientNotification;

class ExperienceController extends Controller
{
    public function all(Request $request)
    {
        $paginateSize = $request->query('paginateSize', 10);
        return response()->json(Experience::where('employee_id', auth('api')->user()->id)->with('company')->paginate($paginateSize));
    }

    public function add(Request $request)
    {
        // return $request ; 
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'employment_type' => 'required|string|max:255',
            'company_id' => 'required|integer|exists:members,id,type,' . UserTypeEnum::COMPANY,
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'location_type' => 'required|string|max:255',
            'status_works' => 'required|string|max:255|in:work,notWork',
            'still_working' => 'nullable|in:0,1',
            'start_date' => 'required|numeric',
            'end_date' => 'required_if:still_working,0|numeric',
            'start_date_year' => 'required|numeric',
            'end_date_year' => 'required_if:still_working,0|numeric|max:'.date("Y"),
            'description' => 'required|string|max:255',
            'profile_headline' => 'required|string|max:255',
        ]);

        $data['employee_id'] = auth('api')->user()->id;

        

        $experience = Experience::create($data);

         # sending a notification to the user   
        $notifabels = Member::find($data['company_id']);
        $notificationData = [
            'title' => " اضافة تعليق عن موظف ",
            'body' => "قام " . auth('api')->user()?->first_name.' '.auth('api')->user()?->last_name . " باضافتكم كشركة عمل بها!",
            'type' => 'experience',
             'id_link' => $experience->id, 
             

        ];

        \Illuminate\Support\Facades\Notification::send(
            $notifabels,
            new ClientNotification($notificationData, ['database', 'firebase'])
        );

        return response()->json([
            'message' => 'تم إضافة الخبرة بنجاح',
            'experience' => $experience
        ]);
    }

    public function get(Request $request, $member)
    {
        $paginateSize = $request->query('paginateSize', 10);
        $member = Member::findOrFail($member);
        return Experience::where('employee_id', $member->id)->with('company')->paginate($paginateSize);
    }

    public function getAll($member)
    {
        $member = Member::findOrFail($member);
        return Experience::where('employee_id', $member->id)->with('company')->get();
    }
    public function getCitiesWorked($Member)
    {
        $Member = Member::find($Member);
        return array_unique($Member->experience()->pluck('city')->toArray());
    }

    public function show($experience)
    {
        $experience = Experience::findOrFail($experience);
        return $experience;
    }

    public function update(Request $request,$experience)
    {
        // return $request ;
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'employment_type' => 'required|string|max:255',
            'company_id' => 'required|integer|exists:members,id,type,' . UserTypeEnum::COMPANY,
             'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'location_type' => 'required|string|max:255',
            'status_works' => 'required|string|max:255|in:work,notWork',
            'still_working' => 'nullable|in:0,1',
            'start_date' => 'required|numeric',
            'end_date' => 'required_if:still_working,0|numeric',
            'start_date_year' => 'required|numeric',
            'end_date_year' => 'required_if:still_working,0|numeric|max:'.date("Y"),
            'description' => 'required|string|max:255',
            'profile_headline' => 'required|string|max:255',
        ]);
        $experience = Experience::findOrFail($experience);
        $data['employee_id'] = auth('api')->user()->id;


        
        $experience->update($data);
        # sending a notification to the user   
        $notifabels = Member::find($data['company_id']);
        $notificationData = [
            'title' => " اضافة تعليق عن موظف ",
            'body' => "قام " . auth('api')->user()?->first_name.' '.auth('api')->user()?->last_name . " باضافتكم كشركة عمل بها!",
             'type' => 'experience',
             'id_link' => $experience->id,     
        ];

        \Illuminate\Support\Facades\Notification::send(
            $notifabels,
            new ClientNotification($notificationData, ['database', 'firebase'])
        );

        return response()->json([
            'message' => 'تم تحديث تفاصيل الخبرة بنجاح',
            'experience' => $experience
        ]);
    }

    public function delete($experience)
    {
        $experience = Experience::findOrFail($experience);
        $experience->delete();

        return response()->json([
            'message' => 'تم حذف تفاصيل الخبرة بنجاح'
        ]);
    }
}

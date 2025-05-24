<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Models\{OverView,Member};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use App\Enum\UserTypeEnum;

class OverViewController extends Controller
{
    public function add(Request $request)
    {
       $data = $request->validate([
           'comment' => ['required','string'],
           'employee_id' => ['required', Rule::exists('members', 'id')->where(function ($query) {
            $query->where('type', UserTypeEnum::EMPLOYEE);})]
     ]);
          $employee = Member::find($data['employee_id']);
            $companies =  $employee?->experience->pluck('company_id')->toArray();
            if (!in_array(auth('api')->id(), $companies)) {
             return response()->json(['message' => 'ليس لديك صلاحيات لأضافة تعليق على هذا المنشور'],403);
            }
        $data['company_id'] = auth('api')->id();
        OverView::create($data);

        /* \DB::beginTransaction();
        OverView::create($data);
        # Notification Implementaion # */

       return response()->json(['message' => 'تم الاضافة بنجاح']);
        // \DB::commit();
        // return response()->json(['message' => 'عملية خاطئة! حاول مرة أخري'],422);
    }

    #SHOW
    public function show(Request $request,$employeeId)
    {
      $paginateSize = $request->query('paginateSize');
      $employee = Member::find($employeeId);
        $hasOverview = Overview::where('company_id',auth('api')->id())
        ->where('employee_id',$employee->id)
        ->count();

       return response()->json([
            'hasOverview' => $hasOverview > 0 ? true : false ,
            'data' =>  $employee->employeeOverview()->paginate($paginateSize),
       ]);
    }
     # UPDATE
    public function update(Request $request,$id)
    {
        $data = $request->validate([
            'comment' => ['nullable','string'],
      ]);
      $overview = OverView::find($id);
         $overview?->update($data);

         /* \DB::beginTransaction();
         $overview->update($data);
         # Notification Implementaion # */
        return response()->json(['message' => 'تم التعديل بنجاح']);
         /* \DB::commit();
         return response()->json(['message' => 'عملية خاطئة! حاول مرة أخري'],422); */
    }

    public function delete($id)
    {
        OverView::whereId($id)->delete();
       return response()->json(['message' => 'تم الحذف بنجاح']);
    }


    
}

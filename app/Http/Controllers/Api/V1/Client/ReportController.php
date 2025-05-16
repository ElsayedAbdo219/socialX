<?php

namespace App\Http\Controllers\Api\V1\Client;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Models\{
    Report,Member,OverView
};

class ReportController extends Controller
{

    public function add(Request $request)
    {
       $data = $request->validate([
           'comment' => ['nullable','string'],
           'over_view_id' => ['required', 'exists:over_views,id']
     ]);
        Report::create($data);
       /*  
        \DB::beginTransaction();
        # Notification Implementaion #
 */
       return response()->json(['message' => 'تم الاضافة بنجاح']);
        // \DB::commit();
        // return response()->json(['message' => 'عملية خاطئة! حاول مرة أخري'],422);
    }

     public function update(Request $request,$id)
    {
       $data = $request->validate([
           'comment' => ['nullable','string'],
     ]);
         $Report = Report::find($id);
        $Report->update($data);

        // \DB::beginTransaction();
        // # Notification Implementaion #

       return response()->json(['message' => 'تم التعديل بنجاح']);
       /*  \DB::commit();
        return response()->json(['message' => 'عملية خاطئة! حاول مرة أخري'],422); */
    }

     public function delete($id)
    {
        Report::whereId($id)->delete();
       return response()->json(['message' => 'تم الحذف بنجاح']);
    }
    


}

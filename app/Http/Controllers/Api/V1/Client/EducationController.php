<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Models\Member;
use App\Models\Education;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EducationController extends Controller
{
    public function all(Request $request)
    {
        $paginateSize = $request->query('paginateSize',10);
        return Education::where('employee_id', auth('api')->user()->id)->paginate($paginateSize);
    }

    public function add(Request $request)
    {
        $data = $request->validate([
            'school' => 'required|string|max:255',
            'degree' => 'required|string|max:255',
            'field_of_study' => 'required|string|max:255',
            'grade' => 'required|string|max:255',
            'start_date' => 'required|numeric',
            'start_date_year' => 'required|numeric',
            'still_education' =>'required|in:0,1|numeric',
            'end_date' => 'required_if:still_education,0|numeric',
            'end_date_year' => 'required_if:still_education,0|numeric|max:'.date("Y"),
            'activities' => 'required|string',
            'description' => 'required|string',
        ]);

        $data['employee_id'] = auth('api')->user()->id;

        $education = Education::create($data);

        return response()->json([
            'message' => 'تم إضافة تفاصيل تعليمك بنجاح',
            'education' => $education
        ]);
    }

    public function get($member)
    {
        $member = Member::findOrfail($member);
        return $member->load('education');
    }

    public function show($education)
    {
        $education = Member::findOrfail($education);
        return $education;
    }

    public function update(Request $request, $education)
    {
        $data = $request->validate([
            'school' => 'required|string|max:255',
            'degree' => 'required|string|max:255',
            'field_of_study' => 'required|string|max:255',
            'grade' => 'required|string|max:255',
            'start_date' => 'required|numeric',
            'start_date_year' => 'required|numeric',
            'still_education' =>'required|in:0,1|numeric',
            'end_date' => 'required_if:still_education,0|numeric',
            'end_date_year' => 'required_if:still_education,0|numeric|max:'.date("Y"),
            'activities' => 'required|string',
            'description' => 'required|string',
        ]);
        $education = Education::findOrFail($education);
        $data['employee_id'] = auth('api')->user()->id;

        $education->update($data);

        return response()->json([
            'message' => 'تم تحديث تفاصيل التعليم بنجاح',
            'education' => $education
        ]);
    }

    public function delete($education)
    {
        $education = Education::findOrFail($education);
        $education->delete();

        return response()->json([
            'message' => 'تم حذف تفاصيل التعليم بنجاح'
        ]);
    }
}

<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Models\Member;
use App\Models\Education;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EducationController extends Controller
{
    public function all()
    {
        return Education::where('employee_id', auth('api')->user()->id)->paginate(10);
    }

    public function add(Request $request)
    {
        $data = $request->validate([
            'school' => 'required|string|max:255',
            'degree' => 'required|string|max:255',
            'field_of_study' => 'required|string|max:255',
            'grade' => 'required|string|max:255',
            'start_date' => 'required|string|max:255',
            'start_date_year' => 'required|string|max:255',
            'end_date' => 'required|string|max:255',
            'end_date_year' => 'required|string|max:255',
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

    public function get(Member $member)
    {
        return $member->load('education');
    }

    public function show(Education $education)
    {
        return $education;
    }

    public function update(Request $request, Education $education)
    {
        $data = $request->validate([
            'school' => 'nullable|string|max:255',
            'degree' => 'nullable|string|max:255',
            'field_of_study' => 'nullable|string|max:255',
            'grade' => 'nullable|string|max:255',
            'start_date' => 'nullable|string|max:255',
            'start_date_year' => 'nullable|string|max:255',
            'end_date' => 'nullable|string|max:255',
            'end_date_year' => 'nullable|string|max:255',
            'activities' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $data['employee_id'] = auth('api')->user()->id;

        $education->update($data);

        return response()->json([
            'message' => 'تم تحديث تفاصيل التعليم بنجاح',
            'education' => $education
        ]);
    }

    public function delete(Education $education)
    {
        $education->delete();

        return response()->json([
            'message' => 'تم حذف تفاصيل التعليم بنجاح'
        ]);
    }
}

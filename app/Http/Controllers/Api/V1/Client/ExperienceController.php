<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Models\Member;
use App\Enum\UserTypeEnum;
use App\Models\Experience;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ExperienceController extends Controller
{
    public function all() 
    {
        return Experience::where('employee_id', auth('api')->user()->id)->paginate(10);
    }

    public function add(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'employment_type' => 'required|string|max:255',
            'company_id' => 'required|integer|exists:members,id,type,' . UserTypeEnum::COMPANY,
            'location' => 'required|string|max:255',
            'location_type' => 'required|string|max:255',
            'status_works' => 'required|string|max:255|in:work,notWork',
            'start_date_year' => 'required|string|max:255',
            'end_date_year' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'profile_headline' => 'required|string|max:255',
            'skill' => 'required|string|max:255',
            'media' => 'nullable|image|mimes:jpeg,png,jpg',
        ]);

        $data['employee_id'] = auth('api')->user()->id;

        if ($request->file('media')) {
            $media = uniqid() . '_' . $request->file('media')->getClientOriginalName();
            Storage::disk("local")->put($media, file_get_contents($request->file('media')));
            $data['media'] = $media;
        }

        $experience = Experience::create($data);

        return response()->json([
            'message' => 'تم إضافة الخبرة بنجاح',
            'experience' => $experience
        ]);
    }

    public function get(Member $member)
    {
        return $member?->load('experience');
    }

    public function show(Experience $experience)
    {
        return $experience;
    }

    public function update(Request $request, Experience $experience)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'employment_type' => 'required|string|max:255',
            'company_id' => 'required|integer|exists:members,id,type,' . UserTypeEnum::COMPANY,
            'location' => 'required|string|max:255',
            'location_type' => 'required|string|max:255',
            'status_works' => 'required|string|max:255|in:work,notWork',
            'start_date_year' => 'required|string|max:255',
            'end_date_year' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'profile_headline' => 'required|string|max:255',
            'skill' => 'required|string|max:255',
            'media' => 'nullable|image|mimes:jpeg,png,jpg',
        ]);

        $data['employee_id'] = auth('api')->user()->id;

        if ($request->file('media')) {
            $media = uniqid() . '_' . $request->file('media')->getClientOriginalName();
            Storage::disk("local")->put($media, file_get_contents($request->file('media')));
            $data['media'] = $media;
        }

        $experience->update($data);

        return response()->json([
            'message' => 'تم تحديث تفاصيل الخبرة بنجاح',
            'experience' => $experience
        ]);
    }

    public function delete(Experience $experience)
    {
        $experience->delete();

        return response()->json([
            'message' => 'تم حذف تفاصيل الخبرة بنجاح'
        ]);
    }
}

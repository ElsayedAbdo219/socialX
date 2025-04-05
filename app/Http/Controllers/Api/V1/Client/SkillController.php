<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Models\Skill;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SkillController extends Controller
{
    public function index()
    {
        return Skill::where('employee_id', auth('api')->id())->paginate(10);
    }

    public function add(Request $request)
    {
        $data = $request->validate([
            'skill' => ['required', 'string', 'max:255'],
        ]);

        $data['employee_id'] = auth('api')->id();
        $skill = Skill::create($data);

        return response()->json([
            'message' => 'تم اضافة مهارة جديدة بنجاح',
            'skill' => $skill
        ]);
    }

    public function get(Member $member)
    {
        return $member->load('skills');
    }

    public function show(Skill $skill)
    {
        if ($skill->employee_id !== auth('api')->id()) {
            return response()->json(['message' => 'غير مصرح لك بعرض هذه المهارة'], 403);
        }

        return $skill;
    }

    public function update(Request $request, Skill $skill)
    {
        if ($skill->employee_id !== auth('api')->id()) {
            return response()->json(['message' => 'غير مصرح لك بتحديث هذه المهارة'], 403);
        }

        $data = $request->validate([
            'skill' => ['required', 'string', 'max:255'],
        ]);

        $skill->update([
            'skill' => $data['skill'],
            'employee_id' => auth('api')->id()
        ]);

        return response()->json([
            'message' => 'تم تحديث المهارة بنجاح',
            'skill' => $skill
        ]);
    }

    public function delete(Skill $skill)
    {
        if ($skill->employee_id !== auth('api')->id()) {
            return response()->json(['message' => 'غير مصرح لك بحذف هذه المهارة'], 403);
        }

        $skill->delete();

        return response()->json(['message' => 'تم حذف المهارة بنجاح']);
    }
}

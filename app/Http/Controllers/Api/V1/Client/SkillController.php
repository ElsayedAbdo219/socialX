<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Models\{Skill,Category,SkillEmployee};
use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SkillController extends Controller
{
    public function all()
    {
        return SkillEmployee::where('employee_id', auth('api')->id())->paginate(10);
    }

    public function getSkillsByCatgory($Category)
    {
       return array_unique(Skill::where('category_id',$Category)->pluck('name')->toArray());

    }

    public function add(Request $request)
    {
        // return $request;
        $data = $request->validate([
            'skill_id' => ['required', 'array'],
            'skill_id' => ['required'],
            'category_id' => ['required'],
        ]);
        // return $data;

        foreach($data['skill_id'] as $val){
            SkillEmployee::create([
                'employee_id' => auth('api')->id(),
                'skill_id' => $val,
                'category_id' => $data['category_id'],
            ]);
        }

        return response()->json([ 'message' => 'تم اضافة مهارة جديدة بنجاح'  ]);
    }

    public function get($member)
    {
        $member = Member::findOrFail($member);
        return $member->load('skills');
    }

    public function show($SkillEmployee)
    {
        $SkillEmployee = SkillEmployee::findOrFail($SkillEmployee);
        if ($SkillEmployee->employee_id !== auth('api')->id()) {
            return response()->json(['message' => 'غير مصرح لك بعرض هذه المهارة'], 403);
        }
        return $SkillEmployee;
    }

    public function update(Request $request, $skill)
    {
        $skill = Skill::findOrFail($skill);
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

    public function delete($skill)
    {
        $skill = SkillEmployee::findOrFail($skill);
        if ($skill->employee_id !== auth('api')->id()) {
            return response()->json(['message' => 'غير مصرح لك بحذف هذه المهارة'], 403);
        }

        $skill->delete();

        return response()->json(['message' => 'تم حذف المهارة بنجاح']);
    }
}

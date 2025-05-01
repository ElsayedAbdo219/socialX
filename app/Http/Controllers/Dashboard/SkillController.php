<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\{Category,Skill};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Datatables\SkillDatatable;

class SkillController extends Controller
{
    protected string $datatable = SkillDatatable::class;
    protected string $route = 'admin.skills';
    protected string $viewPath = 'dashboard.skills.list';

    public function index()
    {
        // return Skill::get();
        // return Skill::query()->latest()->get();

        return $this->datatable::create($this->route)
            ->render($this->viewPath);
    }

    public function create()
    {
        $categories = Category::all();
        return view('dashboard.skills.add',[
            'categories' => $categories
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate(['name' => 'required|string|max:255', 'category_id' => 'required|exists:categories,id']);
        Skill::create($data);
        return redirect()->route($this->route . '.' . 'index')->with('success', __('dashboard.created_skills'));
    }

    public function edit(Skill $Skill)
    {
        $categories = Category::all();
        return view('dashboard.skills.edit',
            [
                'skill' => $Skill,
                'categories' => $categories
            ]

        );
    }


    public function update(Request $request, $Skill)
    {
        // dd($request->all());
        $data = $request->validate(['name' => 'required|string|max:255', 'category_id' => 'required|exists:categories,id']);
        $Skill = Skill::findOrfail($Skill);
        $Skill->update($data);
        return redirect()->route($this->route . '.' . 'index')->with('success', __('dashboard.updated_skill'));

    }


    public function delete($Skill)
    {
        Skill::whereId($Skill)->delete();
        return redirect()->route($this->route . '.' . 'index')->with('success', __('dashboard.deleted_skill'));

    }


}

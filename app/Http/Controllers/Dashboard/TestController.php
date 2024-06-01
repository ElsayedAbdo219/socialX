<?php

namespace App\Http\Controllers\Dashboard;

use App\Datatables\FrequentlyQuestionedAnswerDatatable;
use App\Http\Requests\Dashboard\FrequentlyQuestionedAnswerRequest;
use App\Models\CommonQuestion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponseDashboard;

class TestController extends Controller
{
    use ApiResponseDashboard;
    protected string $datatable = FrequentlyQuestionedAnswerDatatable::class;
    protected string $routeName = 'admin.fqa';
    protected string $viewPath = 'dashboard.fqa.list';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fqa = CommonQuestion::first();
        //$fqa->reorder();
        return $this->datatable::create($this->routeName)
            ->render($this->viewPath);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.fqa.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FrequentlyQuestionedAnswerRequest $request)
    {
        $validated = $request->validated();
        CommonQuestion::create($validated);
        return redirect()->route('admin.fqa.index')->with('success',__('dashboard.item added successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(CommonQuestion $fqa)
    {
        return view('dashboard.fqa.show',['fqa'=> $fqa ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CommonQuestion $fqa)
    {
        return view('dashboard.fqa.edit',['fqa'=> $fqa]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FrequentlyQuestionedAnswerRequest $request, CommonQuestion $fqa)
    {
        $validated = $request->validated();
        $fqa->update($validated);
        return redirect()->route('admin.fqa.index')->with('success',__('dashboard.item updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CommonQuestion $fqa)
    {
        $fqa->delete();
        if (request()->expectsJson()){
            return self::apiCode(200)->apiResponse();
        }
        return redirect()->route('admin.fqa.index')->with('success',__('dashboard.item deleted successfully'));
    }
}
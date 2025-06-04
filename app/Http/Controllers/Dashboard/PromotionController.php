<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Promotion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponseDashboard;
use App\Datatables\PromotionDatatable;
use App\Http\Requests\Dashboard\PromotionRequest;

class PromotionController extends Controller
{
    use ApiResponseDashboard;

    protected $datatable = PromotionDatatable::class;
    protected string $route = 'admin.promotions';
    protected string $viewPath = 'dashboard.promotions.list';


    public function index()
    {
        return $this->datatable::create($this->route)
            ->render($this->viewPath);
    }

    public function create()
    {
        return view('dashboard.promotions.add');
    }
    public function store(PromotionRequest $request)
    {
        // Validate and store the promotion data
        $data = $request->validated();
        $promotion = Promotion::create($data);
        return redirect()->route($this->route.'.index')->with('success', __('dashboard.promotion_created_successfully'));
    }
    public function edit($id)
    {
        $promotion = Promotion::findOrFail($id);
        return view('dashboard.promotions.edit', compact('promotion'));
    }
    public function update(PromotionRequest $request, $id)
    {
        // Validate and update the promotion data
        $data = $request->validated();
        $promotion = Promotion::findOrFail($id);
        $promotion->update($data);

        return redirect()->route($this->route.'.index')->with('success', __('dashboard.promotion_updated_successfully'));
    }
    public function destroy(Promotion $promotion)
    {
        $promotion->delete();
        if (request()->expectsJson()) {
            return self::apiCode(200)->apiResponse();
        }
        return redirect()->route('admin.advertises.index')->with('success', __('dashboard.item deleted successfully'));
    }
    public function toggleActive(Promotion $promotion)
    {
        $promotion->is_active = !$promotion->is_active;
        $promotion->save();

        return redirect()->route($this->route.'.index')->with('success', __('dashboard.promotion_status_updated'));
    }

}

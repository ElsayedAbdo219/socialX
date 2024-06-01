<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use App\Models\GoodType;
use App\Models\SectoralSelling;
use App\Models\Trader;
use App\Datatables\SectoralSaleDatatable;
use App\Http\Requests\Dashboard\SectoralSellingRequest;
use App\Enum\UserTypeEnum;
use App\Models\WholeSale;
use App\Enum\PaymentTypeEnum;
use Illuminate\Http\Request;

class SectoralSellingController extends Controller
{
    protected string  $datatable = SectoralSaleDatatable::class;
    protected string $route = 'admin.sectoral-selling';
    protected string $viewPath = 'dashboard.sectoralselling.list';

    public function index()
    {
        return $this->datatable::create($this->route)
            ->render($this->viewPath);
    }



    public function create()
    {
        $traders = Trader::whereType(UserTypeEnum::CLIENT)->get();
        $goodsTypes = GoodType::all();
        return view(
            'dashboard.sectoralselling.add',
            [
                'traders' => $traders,
                'goodsTypes' => $goodsTypes,
            ]

        );
    }


    public function store(SectoralSellingRequest $request)
    {

        $data = $request->validated();

        SectoralSelling::create([
            'payment_type' => $data['payment_type'],
            'trader_id' => $data['trader_id'],
            'phone' => $data['phone'],
            'payment_amout' => $data['payment_amout'],
            'goods_type_id' => $data['goods_type_id'],
            'unit' => $data['unit'],
            'quantity' => $data['quantity'],
            'unit_price' => $data['unit_price'],
            'total' => $data['quantity'] * $data['unit_price'],
        ]);

        return redirect()->route($this->route . '.' . 'index')->with('success', __('dashboard.created_sectoral_selling_successfully'));
    }

    public function edit($SectoralSelling)
    {
        $traders = Trader::whereType(UserTypeEnum::CLIENT)->get();
        $SectoralSelling = SectoralSelling::whereId($SectoralSelling)->with(['trader','goodType'])->first();
        $goodsTypes = GoodType::all();
        return view(
            'dashboard.sectoralselling.edit',
            [
                'traders' => $traders,
                'SectoralSelling' => $SectoralSelling,
                'goodsTypes' => $goodsTypes,
            ]

        );
    }


    public function update(SectoralSellingRequest $request, $SectoralSelling)
    {
        $data = $request->validated();

        $SectoralSelling= SectoralSelling::whereId($SectoralSelling)->first();

        $SectoralSelling->update([
                'payment_type' => $data['payment_type'],
                'trader_id' => $data['trader_id'],
                'phone' => $data['phone'],
                'payment_amout' => $data['payment_amout'],
                'goods_type_id' => $data['goods_type_id'],
                'unit' => $data['unit'],
                'quantity' => $data['quantity'],
                'unit_price' => $data['unit_price'],
                'total' => $data['quantity'] * $data['unit_price'],
        ]);

        return redirect()->route($this->route . '.' . 'index')->with('success', __('dashboard.update_sectoralselling_successfully'));
    }


    public function delete($SectoralSelling)
    {
        SectoralSelling::whereId($SectoralSelling)->destroy();
        return redirect()->route($this->route . '.' . 'index')->with('success', __('dashboard.deleted_sectoralselling_successfully'));
    }
}

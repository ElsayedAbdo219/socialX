<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Trader;
use App\Models\GoodType;
use App\Models\WholeSale;
use App\Enum\UserTypeEnum;
use Illuminate\Http\Request;
use App\Enum\PaymentTypeEnum;
use App\Http\Controllers\Controller;
use App\Datatables\WholeSaleDatatable;
use App\Http\Requests\Dashboard\WholeSaleRequest;

class WholeSaleController extends Controller
{

    protected string  $datatable = WholeSaleDatatable::class;

    protected string $route = 'admin.WholeSale';
    protected string $viewPath = 'dashboard.wholesale.list';

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
            'dashboard.wholesale.add',
            [
                'traders' => $traders,
                'goodsTypes' => $goodsTypes,
            ]

        );
    }

    public function store(WholeSaleRequest $request)
    {

        $data = $request->validated();

        WholeSale::create([
            'trader_id' => $data['trader_id'],
            'phone' => $data['phone'],
            'goods_type_id' => $data['goods_type_id'],
            'ton_quantity' => $data['ton_quantity'],
            'ton_quantity_price' => $data['ton_quantity_price'],
            'delivery_way' => $data['delivery_way'],
            'ton_nolon_price' => $data['ton_nolon_price'],
            'payment_type' => $data['payment_type'],
            'deposit_money' => $data['deposit_money'],
            'first_amount' => $data['first_amount'] ,
            'duration' => $data['duration'],
            'total' => isset($data['ton_nolon_price']) ?
             ($data['ton_quantity'] * $data['ton_quantity_price']) + ($data['ton_quantity'] * $data['ton_nolon_price'])  :
                $data['ton_quantity'] * $data['ton_quantity_price'],
        ]);

        return redirect()->route($this->route . '.' . 'index')->with('success', __('dashboard.created_whole_successfully'));
    }

    public function edit($SectoralSelling)
    {
        $traders = Trader::whereType(UserTypeEnum::CLIENT)->get();
        $thisWholeSale = WholeSale::whereId($SectoralSelling)->with(['trader','goodType'])->first();
        $goodsTypes = GoodType::all();
        return view(
            'dashboard.wholesale.edit',
            [
                'traders' => $traders,
                'wholesale' => $thisWholeSale,
                'goodsTypes' => $goodsTypes,
            ]

        );
    }


    public function update(WholeSaleRequest $request, $SectoralSelling)
    {
        $data = $request->validated();
        $SectoralSelling= WholeSale::whereId($SectoralSelling)->first();

        $SectoralSelling->update([
            'trader_id' => $data['trader_id'],
            'phone' => $data['phone'],
            'goods_type_id' => $data['goods_type_id'],
            'ton_quantity' => $data['ton_quantity'],
            'ton_quantity_price' => $data['ton_quantity_price'],
            'delivery_way' => $data['delivery_way'],
            'ton_nolon_price' => $data['ton_nolon_price'],
            'payment_type' => $data['payment_type'],
            'deposit_money' => $data['deposit_money'],
            'first_amount' => $data['first_amount'] ,
            'duration' => $data['duration'],
            'total' => isset($data['ton_nolon_price']) ?
             ($data['ton_quantity'] * $data['ton_quantity_price']) + ($data['ton_quantity'] * $data['ton_nolon_price'])  :
                $data['ton_quantity'] * $data['ton_quantity_price'],
        ]);

        return redirect()->route($this->route . '.' . 'index')->with('success', __('dashboard.update_whole_successfully'));
    }


    public function delete($SectoralSelling)
    {
        WholeSale::whereId($SectoralSelling)->destroy();
        return redirect()->route($this->route . '.' . 'index')->with('success', __('dashboard.deleted_whole_successfully'));
    }
}

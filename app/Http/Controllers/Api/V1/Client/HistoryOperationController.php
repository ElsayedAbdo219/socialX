<?php

namespace App\Http\Controllers\Api\V1\Client;

use Carbon\Carbon;
use App\Models\Custody;
use App\Models\UserReport;
use Illuminate\Http\Request;
use App\Enum\OperationTypeEnum;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Enum\UserReportTypeEnum;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf;
use App\Http\Resources\Api\V1\Client\CustodyResource;
use App\Enum\{DepositTypeEnum, MoneyTypeEnum, UserTypeEnum};
use App\Http\Resources\Api\V1\Client\{DrawerResource, PurchasingResource};
use App\Models\{DepositOperation, Trader, FinancialUser, purchasing, SectoralSelling, WholeSale};
use App\Http\Resources\Api\V1\Client\{TraderResource, DepositOperationResource, SectoralSellingResource, WholeSaleResource};


class HistoryOperationController extends Controller
{

  use ApiResponseTrait;
  protected  $PurchasingResource = PurchasingResource::class;
  protected $SectoralSellingResource = SectoralSellingResource::class;
  protected $WholeSaleResource = WholeSaleResource::class;
  protected $DepositOperationResource = DepositOperationResource::class;


  public function totalTodayselling()
  {
    $sellsTotalWhole = WholeSale::query()->ofUser(auth()->id())->whereDate('created_at', Carbon::today())->select('id', 'total')->get();
    // return $sellsTotalWhole->sum('total');
    $sellsTotalSectoral = SectoralSelling::query()->ofUser(auth()->id())->whereDate('created_at', Carbon::today())->select('id', 'total')->get();
    return [
      "sellstotalToday" =>  $sellsTotalSectoral->sum('total') +  $sellsTotalWhole->sum('total') . ' ' . __('messages.pound'),
      "WholeToday" =>  $sellsTotalWhole->sum('total') . ' ' . __('messages.pound'),
      "SectoralToday" =>  $sellsTotalSectoral->sum('total') . ' ' . __('messages.pound'),
    ];
  }

  public function getData(Request $request)
  {

    ##################################################Start
    if ($request->type === 'notebook') {

      $sellsTotalWhole = WholeSale::query()
        ->ofUser(auth()->id())
        ->when($request->from && $request->to, function ($query) use ($request) {
          return $query->whereDate('created_at', '>=', $request->from)
            ->whereDate('created_at', '<=', $request->to);
        })
        ->when($request->delivery_type, function ($query) use ($request) {
          return $query->where('delivery_way', $request->delivery_type);
        })
        ->when($request->payment_type, function ($query) use ($request) {
          return $query->where('payment_type', $request->payment_type);
        })
        ->when($request->goods_type, function ($query) use ($request) {
          return $query->whereHas('goodType', function ($query) use ($request) {
            return $query->where('id', $request->goods_type);
          });
        })
        ->when($request->trader_id, function ($query) use ($request) {
          return $query->whereHas('trader', function ($query) use ($request) {
            return $query->where('id', $request->trader_id);
          });
        })
        ->when($request->filled('keyword_searchable'), function ($query) use ($request) {
          return $query->whereHas('trader', function ($query) use ($request) {
            return $query->where('name', $request->keyword_searchable);
          });
        })
        ->get();


      $purchasing = purchasing::query()
        ->ofUser(auth()->id())
        ->when($request->from && $request->to, function ($query) use ($request) {
          return $query->whereDate('created_at', '>=', $request->from)
            ->whereDate('created_at', '<=', $request->to);
        })
        ->when($request->trader_type, function ($query) use ($request) {
          return $query->where('type', $request->trader_type);
        })
        ->when($request->payment_type, function ($query) use ($request) {
          return $query->where('payment_way', $request->payment_type);
        })
        ->when($request->payment_type, function ($query) use ($request) {
          return $query->where('payment_way', $request->payment_type);
        })
        ->when($request->goods_type, function ($query) {
          return $query->whereHas('goodType', function ($query) {
            return $query->where('id', request()->goods_type);
          });
        })
        ->when($request->trader_id, function ($query) use ($request) {
          return $query->whereHas('trader', function ($query) use ($request) {
            return $query->where('id', $request->trader_id);
          });
        })
        ->when($request->filled('keyword_searchable'), function ($query) {
          return $query->whereHas('trader', function ($query) {
            return $query->where('name', request()->keyword_searchable);
          });
        })
        ->get();

      $depoitOperations = DepositOperation::where('deposit_operation_type', OperationTypeEnum::WHOLE)->ofUser(auth()->id())->when($request->from && $request->to, function ($query) use ($request) {
        return $query->whereDate('created_at', '>=', $request->from)
          ->whereDate('created_at', '<=', $request->to)
          ->when($request->filled('keyword_searchable'), function ($query) {
            return $query->whereHas('trader', function ($query) {
              return $query->where('name', request()->keyword_searchable);
            });
          });
      })->when($request->trader_id, function ($query) use ($request) {
        return $query->whereHas('trader', function ($query) use ($request) {
          return $query->where('id', $request->trader_id);
        });
      })->get();



      $collection = PurchasingResource::collection($purchasing)
        ->merge(WholeSaleResource::collection($sellsTotalWhole))
        ->merge(DepositOperationResource::collection($depoitOperations));

      $collectionSorted = $collection->sortByDesc('created_at')->values();
      //  return $collectionSorted;

      $customPaginated = $collectionSorted->customPaginate(20);

      return $customPaginated;
    }

    ################################################End
    ###############################################Start
    #  معاملات الدرج
    elseif ($request->type === 'drawer' && !in_array($request->trader_type,[UserTypeEnum::COMPANY,UserTypeEnum::SUPPLIER])) {


      $sellsTotalSectoral = SectoralSelling::query()
        ->ofUser(auth()->id())
        ->when($request->from && $request->to, function ($query) use ($request) {
          return $query->whereDate('created_at', '>=', $request->from)
            ->whereDate('created_at', '<=', $request->to);
        })
        ->when($request->unit, function ($query) use ($request) {
          return $query->where('unit', $request->unit);
        })
        ->when($request->goods_type, function ($query) {
          return $query->whereHas('goodType', function ($query) {
            return $query->where('id', request()->goods_type);
          });
        })
        ->when($request->trader_id, function ($query) use ($request) {
          return $query->whereHas('trader', function ($query) use ($request) {
            return $query->where('id', $request->trader_id);
          });
        })
        ->when($request->delivery_type, function ($query) use ($request) {
          return $query->where('delivery_way', $request->delivery_type);
        })
        ->when($request->payment_type, function ($query) use ($request) {
          return $query->where('payment_type', $request->payment_type);
        })
        ->when($request->filled('keyword_searchable'), function ($query) {
          return $query->whereHas('trader', function ($query) {
            return $query->where('name', request()->keyword_searchable);
          });
        })
        ->get();



      $sellsTotalWhole = WholeSale::query()->whereHas('trader', function ($query) {
        return $query->where('name', UserTypeEnum::MAKHZANY);
      })
        ->ofUser(auth()->id())
        ->when($request->from && $request->to, function ($query) use ($request) {
          return $query->whereDate('created_at', '>=', $request->from)
            ->whereDate('created_at', '<=', $request->to);
        })
        ->when($request->delivery_type, function ($query) use ($request) {
          return $query->where('delivery_way', $request->delivery_type);
        })
        ->when($request->payment_type, function ($query) use ($request) {
          return $query->where('payment_type', $request->payment_type);
        })
        ->when($request->goods_type, function ($query) use ($request) {
          return $query->whereHas('goodType', function ($query) use ($request) {
            return $query->where('id', $request->goods_type);
          });
        })
        ->when($request->trader_id, function ($query) use ($request) {
          return $query->whereHas('trader', function ($query) use ($request) {
            return $query->where('id', $request->trader_id);
          });
        })
        ->when($request->filled('keyword_searchable'), function ($query) use ($request) {
          return $query->whereHas('trader', function ($query) use ($request) {
            return $query->where('name', $request->keyword_searchable);
          });
        })
        ->get();

      $depoitOperations = DepositOperation::where('deposit_operation_type', OperationTypeEnum::SECTORAL)->ofUser(auth()->id())->when($request->from && $request->to, function ($query) use ($request) {
        return $query->whereDate('created_at', '>=', $request->from)
          ->whereDate('created_at', '<=', $request->to)
          ->when($request->filled('keyword_searchable'), function ($query) {
            return $query->whereHas('trader', function ($query) {
              return $query->where('name', request()->keyword_searchable);
            });
          });
      })->when($request->trader_id, function ($query) use ($request) {
        return $query->whereHas('trader', function ($query) use ($request) {
          return $query->where('id', $request->trader_id);
        });
      })->get();





      $collection = SectoralSellingResource::collection($sellsTotalSectoral)

        ->merge(WholeSaleResource::collection($sellsTotalWhole))

        ->merge(DepositOperationResource::collection($depoitOperations));

      $collectionSorted = $collection->sortByDesc('created_at')->values();

      $customPaginated = $collectionSorted->customPaginate(5);


      return $customPaginated;
    }

    return $this->respondWithError('إختيار غير صحيح');
    ############################################End
  }

  # رصيد(الاسبوع) ل الدرج
  public function getOnDrawerThisWeek()
  {

    $sellsTotalSectoral = SectoralSelling::query()
      ->ofUser(auth()->id())
      ->whereDate('created_at', '>=', now()->subDays(7))
      ->selectRaw('DATE(created_at) as date, SUM(total) as total')
      ->groupBy('date')
      ->orderBy('date')
      ->get(['date', 'total']);

      $data = [];
      for ($i = 0; $i < 7; $i++) {
        $dayNow = Carbon::now()->subDays($i)->format('Y-m-d');
        if(in_array($dayNow,$sellsTotalSectoral?->pluck('date')->toArray())){
          $data[$i]['total'] = $sellsTotalSectoral->where('date', $dayNow)->first()?->total;
          $data[$i]['date'] = $sellsTotalSectoral->where('date', $dayNow)->first()?->date;
        }else{
          $data[$i]['date'] = $dayNow;
          $data[$i]['total'] = 0;
        }
    }

    return [
      "drawer_balance" => auth()->user()->financial->drawer_balance . ' ' . __('messages.pound'),
      "ton_numbers" => auth()->user()->financial->drawer_ton . ' ' . __('messages.ton'),
      "drawer_balance_This_Week" =>$sellsTotalSectoral->sum("total") . ' ' . __('messages.pound'),
      "drawer_balance_This_Week_every_day" => $data,
    ];
  }


  # رصيد(الاسبوع) ل الدفتر
  public function getOnNotebookThisWeek()
  {

    $sellsTotalWhole = WholeSale::query()
      ->ofUser(auth()->id())
      ->whereDate('created_at', '>=', now()->subDays(7))
      ->selectRaw('DATE(created_at) as date, SUM(total) as total')
      ->groupBy('date')
      ->orderBy('date')
      ->get(['date', 'total']);
    
      $data = [];
      for ($i = 0; $i < 7; $i++) {
        $dayNow = Carbon::now()->subDays($i)->format('Y-m-d');
        if(in_array($dayNow,$sellsTotalWhole?->pluck('date')->toArray())){
          $data[$i]['total'] = $sellsTotalWhole->where('date', $dayNow)->first()?->total;
          $data[$i]['date'] = $sellsTotalWhole->where('date', $dayNow)->first()?->date;
        }else{
          $data[$i]['date'] = $dayNow;
          $data[$i]['total'] = 0;
        }
    }





    return [
      "notebook_balance" => auth()->user()->financial->notebook_balance . ' ' . __('messages.pound'),
      "ton_numbers" => auth()->user()->financial->notebook_ton . ' ' . __('messages.ton'),
      "notebook_balance_This_Week" =>$sellsTotalWhole->sum("total") . ' ' . __('messages.pound'),
      "notebook_balance_This_Week_every_day" => $data,
    ];
  }



  # 1
  public function generatePdfAllCustodies(Request $request)
  {

    $custodies = Custody::ofUser(auth()->id())->get() ?? [];

    $customPaginated = CustodyResource::collection($custodies)->customPaginate(20);

    $pdf = LaravelMpdf::loadView(
      'pdf.allCustodies',
      ['customPaginated' => $customPaginated],
      [],
      [
        'title' => 'Certificate',
        'format' => 'A4-L',
        'orientation' => 'L'
      ]
    );
    //  return $pdf->stream();

    $pdfFilename = uniqid() . '.pdf';
    $pdfPath = storage_path('app/public/' . $pdfFilename);
    $pdf->save($pdfPath);

    return response()->json(['pdf_url' => Storage::url('public/' . $pdfFilename)]);
  }

  # 2
  public function generatePdfAnotherDeposits(Request $request)
  {

    $anotherDeposits = DepositOperation::ofUser(auth()->id())->where('deposit_type', DepositTypeEnum::ANOTHER_ACCOUNT)->get() ?? [];

    $customPaginated = DepositOperationResource::collection($anotherDeposits)->customPaginate(20);

    $pdf = LaravelMpdf::loadView(
      'pdf.allanotherDepoits',
      ['customPaginated' => $customPaginated],
      [],
      [
        'title' => 'Certificate',
        'format' => 'A4-L',
        'orientation' => 'L'
      ]
    );
    // return $pdf->stream();

    $pdfFilename = uniqid() . '.pdf';
    $pdfPath = storage_path('app/public/' . $pdfFilename);
    $pdf->save($pdfPath);

    return response()->json(['pdf_url' => Storage::url('public/' . $pdfFilename)]);
  }

  # 3
  public function generatePdfAllDeposits(Request $request)
  {

    $Deposits = DepositOperation::ofUser(auth()->id())->whereHas('trader', function ($query) {
      $query->where('type', UserTypeEnum::COMPANY);
    })->get() ?? [];

    $customPaginated = DepositOperationResource::collection($Deposits)->customPaginate(20);

    $pdf = LaravelMpdf::loadView(
      'pdf.allDeposits',
      ['customPaginated' => $customPaginated],
      [],
      [
        'title' => 'Certificate',
        'format' => 'A4-L',
        'orientation' => 'L'
      ]
    );
    // return $pdf->stream();

    $pdfFilename = uniqid() . '.pdf';
    $pdfPath = storage_path('app/public/' . $pdfFilename);
    $pdf->save($pdfPath);

    return response()->json(['pdf_url' => Storage::url('public/' . $pdfFilename)]);
  }


  # 4
  public function generatePdfAllCredits(Request $request)
  {

    $creditsTraders = Trader::ofUser(auth()->id())->get();

    $credits = $creditsTraders->filter(function ($trader) {
      return $trader->credit_balance > 0 || $trader->credit_balance_sectoral > 0;
    });

    $customPaginated = TraderResource::collection($credits)->customPaginate(20);

    $pdf = LaravelMpdf::loadView(
      'pdf.allCredit',
      ['customPaginated' => $customPaginated],
      [],
      [
        'title' => 'Certificate',
        'format' => 'A4-L',
        'orientation' => 'L'
      ]
    );
    //  return $pdf->stream();

    $pdfFilename = uniqid() . '.pdf';
    $pdfPath = storage_path('app/public/' . $pdfFilename);
    $pdf->save($pdfPath);

    return response()->json(['pdf_url' => Storage::url('public/' . $pdfFilename)]);
  }

  # 5
  public function generatePdfAllDebits(Request $request)
  {

    $debitsTraders = Trader::ofUser(auth()->id())->get();

    $debits = $debitsTraders->filter(function ($trader) {
      return $trader->debit_balance > 0 || $trader->debit_balance_sectoral > 0;
    });

    $customPaginated = TraderResource::collection($debits)->customPaginate(20);

    $pdf = LaravelMpdf::loadView(
      'pdf.allDebit',
      ['customPaginated' => $customPaginated],
      [],
      [
        'title' => 'Certificate',
        'format' => 'A4-L',
        'orientation' => 'L'
      ]
    );
    // return $pdf->stream();

    $pdfFilename = uniqid() . '.pdf';
    $pdfPath = storage_path('app/public/' . $pdfFilename);
    $pdf->save($pdfPath);

    return response()->json(['pdf_url' => Storage::url('public/' . $pdfFilename)]);
  }



  public function getTransaction(Request $request, $id)
  {

    if ($request->operation_type == 'whole_selling') {
      $sellsTotalWhole = WholeSale::with(['goodType', 'trader'])->where('id', $id)->ofUser(auth()->id())->first();
      return $sellsTotalWhole;
    } elseif ($request->operation_type == 'sectoral_selling') {
      $sellsTotalsectoral = SectoralSelling::with(['goodType', 'trader'])->where('id', $id)->ofUser(auth()->id())->first();
      return $sellsTotalsectoral;
    } elseif ($request->operation_type == 'purshase_from_supplier' || $request->operation_type == 'purshase_from_company') {
      $purchasing = purchasing::with(['goodType', 'trader'])->where('id', $id)->ofUser(auth()->id())->first();
      return $purchasing;
    } elseif ($request->operation_type == 'custody') {
      $Custody = Custody::where('id', $id)->ofUser(auth()->id())->first();
      return $Custody;
    } else {
      $DepositOperation = DepositOperation::with(['depositAnother', 'trader'])->where('id', $id)->ofUser(auth()->id())->first();
      return $DepositOperation;
    }
  }
}

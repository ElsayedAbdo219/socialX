<?php

namespace App\Http\Controllers\Api\V1\Client;

use Carbon\Carbon;
use App\Models\Custody;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf;
use App\Http\Resources\Api\V1\Client\CustodyResource;
use App\Enum\{DepositTypeEnum, MoneyTypeEnum, UserTypeEnum};

use App\Http\Resources\Api\V1\Client\{DrawerResource, PurchasingResource};
use App\Models\{DepositOperation, Trader, FinancialUser, purchasing, SectoralSelling, WholeSale};
use App\Http\Resources\Api\V1\Client\{TraderResource,
    DepositOperationResource,
    SectoralSellingResource,
    WholeSaleResource};


class ReportController extends Controller
{

    public function getData(Request $request)
    {
        $customPaginated = collect();

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

            $depoitOperations = DepositOperation::query()->ofUser(auth()->id())->when($request->from && $request->to, function ($query) use ($request) {
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


        }

        ################################################End
        ###############################################Start
        #  معاملات الدرج
        elseif ($request->type === 'drawer') {


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
                ->when($request->filled('keyword_searchable'), function ($query) {
                    return $query->whereHas('trader', function ($query) {
                        return $query->where('name', request()->keyword_searchable);
                    });
                })
                ->get();

                $depoitOperations = DepositOperation::query()->ofUser(auth()->id())->when($request->from && $request->to, function ($query) use ($request) {
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


                $sellsTotalWhole = WholeSale::query()->whereHas('trader',function($query){
                    return $query->where('name',UserTypeEnum::MAKHZANY);
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


              $collection = SectoralSellingResource::collection($sellsTotalSectoral)
               ->merge(WholeSaleResource::collection($sellsTotalWhole))
               ->merge(DepositOperationResource::collection($depoitOperations));

            $collectionSorted = $collection->sortByDesc('created_at')->values();

            $customPaginated = $collectionSorted->customPaginate(5);

        }


        $pdf = LaravelMpdf::loadView('pdf.report', ['customPaginated' => $customPaginated],
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

}

<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Member;
use App\Models\Sponser;
use App\Enum\UserTypeEnum;
use Illuminate\Http\Request;
use App\Enum\PaymentTypeEnum;
use App\Enum\StatusTypeSponserEnum;
use App\Datatables\SponserDatatable;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponseDashboard;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Dashboard\AddSponserPostRequest;

class SponserController extends Controller
{
  use ApiResponseDashboard;

  protected string $datatable = SponserDatatable::class;
  protected string $routeName = 'admin.sponsers';
  protected string $viewPath = 'dashboard.sponsers.list';

  public function index()
  {
    return $this->datatable::create($this->routeName)
      ->render($this->viewPath);
  }


  public function create()
  {
    // dd(StatusTypeSponserEnum::toArray() ,PaymentTypeEnum::toArray() );
    return view('dashboard.sponsers.add', [
      'users' => Member::where('type', UserTypeEnum::COMPANY)->get(),
      'statusTypes' => StatusTypeSponserEnum::toArray(),
      'paymentStatusTypes' => PaymentTypeEnum::specialArray(),
    ]);
  }


  public function store(AddSponserPostRequest $request)
  {
    $data = $request->validated();
    $data['image'] = basename(Storage::disk('public')->put('sponsers', $request->file('image')));
    Sponser::create($data);
    return redirect()->route($this->routeName . '.index')
      ->with('success', __('dashboard.sponser_created_successfully'));
  }





  public function destroy(Sponser $Sponser)
  {
    $Sponser->delete();
    Storage::disk('public')->delete('sponsers/' . $Sponser->image);
    if (request()->expectsJson()) {
      return self::apiCode(200)->apiResponse();
    }
    return redirect()->route($this->routeName . '.index')->with('success', __('dashboard.item deleted successfully'));
  }


public function updateOrder(Request $request)
{
    if (!$request->has('order')) {
        return response()->json(['message' => 'لم يتم إرسال الترتيب'], 422);
    }
    $request->validate([
        'order' => 'required|array',
        'order.*.id' => 'required|integer|exists:sponsers,id',
        'order.*.position' => 'required|integer',
    ]);

    foreach ($request->input('order') as $item) {
        Sponser::where('id', $item['id'])->update(['order' => $item['position']]);
    }

    return response()->json(['message' => 'تم حفظ الترتيب بنجاح']);
}

}

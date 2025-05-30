<?php
namespace App\Http\Controllers\Dashboard;
use App\Models\Member;
use App\Models\Sponser;
use App\Enum\UserTypeEnum;
use App\Enum\StatusTypeSponserEnum;
use App\Enum\PaymentTypeEnum;
use App\Datatables\SponserDatatable;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Dashboard\AddSponserPostRequest;
use App\Traits\ApiResponseDashboard;

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
        return view('dashboard.sponsers.add',[
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
        if (request()->expectsJson()) {
            return self::apiCode(200)->apiResponse();
        }
        return redirect()->route($this->routeName . '.index')->with('success', __('dashboard.item deleted successfully'));
    }
}
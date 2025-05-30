<?php

namespace App\Http\Controllers\Api\V1\Client;

use Illuminate\Http\Request;
use App\Models\{
    Rate,
    RateCompany,
    RateEmployee,
    Member
};
use App\Http\Controllers\Controller;
use App\Enum\UserTypeEnum;
use Illuminate\Validation\Rule;

class RateController extends Controller
{
    public function all(Request $request)
    {
        // return auth('api')->id();
        $paginateSize = $request->query('paginateSize');

        if (auth('api')->user()->type === UserTypeEnum::COMPANY) {

            $myRates = RateCompany::OfCompany(auth('api')->user()->id)->get();
            $total = $myRates?->count() > 0 ? $myRates->sum('rate') / $myRates?->count() : 0;
            $ratesMiddleOneStar = $myRates?->where('rate',1)->count();
            $ratesMiddleTwoStar = $myRates?->where('rate',2)->count();
            $ratesMiddleThreeStar = $myRates?->where('rate',3)->count();
            $ratesMiddleFourStar = $myRates?->where('rate',4)->count();
            $ratesMiddleFiveStar = $myRates?->where('rate',5)->count();

            return response()->json([
                 'ratesNumber' => $myRates?->count(),
                 'ratesMiddleOneStar' => $ratesMiddleOneStar,
                 'ratesMiddleTwoStar' => $ratesMiddleTwoStar,
                 'ratesMiddleThreeStar' => $ratesMiddleThreeStar,
                 'ratesMiddleFourStar' => $ratesMiddleFourStar,
                 'ratesMiddleFiveStar' => $ratesMiddleFiveStar,
                 'ratesMiddleTotal' => round($total, 1),
                 'data' =>  RateCompany::where('company_id', auth('api')->user()->id)->with('employee')->paginate($paginateSize),
            ]);

        } else {

            $myRates = RateEmployee::OfEmployee(auth('api')->user()->id)->get();
            $total = $myRates?->count() > 0 ? $myRates->sum('rate') / $myRates?->count() : 0;
            $ratesMiddleOneStar = $myRates?->where('rate',1)->count();
            $ratesMiddleTwoStar = $myRates?->where('rate',2)->count();
            $ratesMiddleThreeStar = $myRates?->where('rate',3)->count();
            $ratesMiddleFourStar = $myRates?->where('rate',4)->count();
            $ratesMiddleFiveStar = $myRates?->where('rate',5)->count();

            return response()->json([
                 'ratesNumber' => $myRates?->count(),
                 'ratesMiddleOneStar' => $ratesMiddleOneStar,
                 'ratesMiddleTwoStar' => $ratesMiddleTwoStar,
                 'ratesMiddleThreeStar' => $ratesMiddleThreeStar,
                 'ratesMiddleFourStar' => $ratesMiddleFourStar,
                 'ratesMiddleFiveStar' => $ratesMiddleFiveStar,
                 'ratesMiddleTotal' => round($total, 1),
                 'data' =>  RateEmployee::where('employee_id', auth('api')->user()->id)->with('company')->paginate($paginateSize),
            ]);

        }
    }

    public function add(Request $request)
    {
        if (auth('api')->user()->type === UserTypeEnum::COMPANY) {
            return $this->validateAddCompany($request);
        } else {
            return $this->validateAddEmployee($request);
        }
    }

    public function showEmployee(Request $request,$employee)
    {
        $paginateSize = $request->query('paginateSize');
        $employee = Member::findOrFail($employee);
        $myRates = RateEmployee::OfEmployee($employee?->id)->get();

        $total = $myRates?->count() > 0 ? $myRates->sum('rate') / $myRates?->count() : 0;
        $ratesMiddleOneStar = $myRates?->where('rate',1)->count();
        $ratesMiddleTwoStar = $myRates?->where('rate',2)->count();
        $ratesMiddleThreeStar = $myRates?->where('rate',3)->count();
        $ratesMiddleFourStar = $myRates?->where('rate',4)->count();
        $ratesMiddleFiveStar = $myRates?->where('rate',5)->count();
        $hasRate = RateEmployee::OfEmployee($employee?->id)->OfCompany(auth('api')->user()->id)->count();


        return response()->json([
            'hasRate' => $hasRate > 0 ? true : false ,
            'ratesNumber' => $myRates?->count(),
            'ratesMiddleOneStar' => $ratesMiddleOneStar,
            'ratesMiddleTwoStar' => $ratesMiddleTwoStar,
            'ratesMiddleThreeStar' => $ratesMiddleThreeStar,
            'ratesMiddleFourStar' => $ratesMiddleFourStar,
            'ratesMiddleFiveStar' => $ratesMiddleFiveStar,
            'ratesMiddleTotal' => round($total, 1),
            'data' =>  RateEmployee::where('employee_id', $employee->id)->with('company')->paginate($paginateSize),
       ]);
    }

    public function showCompany(Request $request,$company)
    {
        $paginateSize = $request->query('paginateSize');
        $company = Member::findOrFail($company);
        $Rates = RateCompany::OfCompany($company?->id)->get();
        $total = $Rates?->count() > 0 ? $Rates->sum('rate') / $Rates?->count() : 0;
        $ratesMiddleTwoStar = $Rates?->where('rate',2)->count();
        $ratesMiddleOneStar = $Rates?->where('rate',1)->count();
        $ratesMiddleFourStar = $Rates?->where('rate',4)->count();
        $ratesMiddleThreeStar = $Rates?->where('rate',3)->count();
        $ratesMiddleFiveStar = $Rates?->where('rate',5)->count();
        $hasRate = RateCompany::OfCompany($company?->id)->OfEmployee(auth('api')->user()->id)->count();


        return response()->json([
            'hasRate' => $hasRate > 0 ? true : false ,
            'ratesNumber' => $Rates?->count(),
            'ratesMiddleOneStar' => $ratesMiddleOneStar,
            'ratesMiddleTwoStar' => $ratesMiddleTwoStar,
            'ratesMiddleThreeStar' => $ratesMiddleThreeStar,
            'ratesMiddleFourStar' => $ratesMiddleFourStar,
            'ratesMiddleFiveStar' => $ratesMiddleFiveStar,
            'ratesMiddleTotal' => round($total, 1),
            'data' =>  RateCompany::where('company_id', $company->id)->with('employee')->paginate($paginateSize),
       ]);
    }

    public function update(Request $request, $rateId)
    {
        if (auth('api')->user()->type === UserTypeEnum::COMPANY) {
            return $this->validateUpdateCompany($request, $rateId);
        } else {
            return $this->validateUpdateEmployee($request, $rateId);
        }
    }

    public function delete($rateId)
    {
        if (auth('api')->user()->type === UserTypeEnum::COMPANY) {
            RateEmployee::where('id', $rateId)->delete();
        } else {
            RateCompany::where('id', $rateId)->delete();
        }

        return response()->json(['message' => 'تم حذف التقييم بنجاح']);
    }

    # Add rate functions
    public function validateAddCompany(Request $request)
    {
        $data = $request->validate([
            'comment' => ['nullable', 'string'],
            'employee_id' => [
                'required',
                Rule::exists('members', 'id')->where(function ($query) {
                    $query->where('type', UserTypeEnum::EMPLOYEE);
                })
            ],
            'rate' => ['required', 'numeric', 'min:1', 'max:5'],
        ]);

        $data['company_id'] = auth('api')->user()->id;
        RateEmployee::create($data);
        return response()->json(['message' => 'تم اضافة تقيم بنجاح']);
    }

    public function validateAddEmployee(Request $request)
    {
        $data = $request->validate([
            'comment' => ['nullable', 'string'],
            'company_id' => [
                'required',
              'exists:members,id'
            ],
            'rate' => ['required', 'numeric', 'min:1', 'max:5'],
        ]);
       // edit( the company id can be employee also , i mean company id can be employee id )
        $data['employee_id'] = auth('api')->user()->id;
        RateCompany::create($data);
        return response()->json(['message' => 'تم اضافة تقيم بنجاح']);
    }

    # Update rate functions
    public function validateUpdateCompany(Request $request, $rateId)
    {
        $data = $request->validate([
            'comment' => ['nullable', 'string'],
            'employee_id' => [
                'required',
                Rule::exists('members', 'id')->where(function ($query) {
                    $query->where('type', UserTypeEnum::EMPLOYEE);
                })
            ],
            'rate' => ['required', 'numeric', 'min:1', 'max:5'],
        ]);

        $data['company_id'] = auth('api')->user()->id;
        $rate = RateEmployee::findOrFail($rateId);
        $rate->update($data);
        return response()->json(['message' => 'تم تحديث التقييم بنجاح']);
    }

    public function validateUpdateEmployee(Request $request, $rateId)
    {
        $data = $request->validate([
            'comment' => ['nullable', 'string'],
            'company_id' => [
                'required',
                'exists:members,id'
            ],
            'rate' => ['required', 'numeric', 'min:1', 'max:5'],
        ]);

        $data['employee_id'] = auth('api')->user()->id;
        $rate = RateCompany::findOrFail($rateId);
        $rate->update($data);
        return response()->json(['message' => 'تم تحديث التقييم بنجاح']);
    }
}

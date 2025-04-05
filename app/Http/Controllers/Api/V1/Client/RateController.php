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
    public function all()
    {
        if (auth('api')->user()->type === UserTypeEnum::COMPANY) {
            return RateEmployee::where('company_id', auth('api')->user()->id)->paginate();
        } else {
            return RateCompany::where('employee_id', auth('api')->user()->id)->paginate();
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

    public function showEmployee(Member $employee)
    {
        $myRates = RateCompany::OfEmployee($employee?->id)->get();
        $total = $myRates?->count() > 0 ? $myRates->sum('rate') / $myRates?->count() : 0;
        return response()->json([
            'rates' => round($total, 1),
            'comments' => $myRates->pluck('comment'),
        ]);
    }

    public function showCompany(Member $company)
    {
        $myRates = RateEmployee::OfCompany($company?->id)->get();
        $total = $myRates?->count() > 0 ? $myRates->sum('rate') / $myRates?->count() : 0;
        return response()->json([
            'rates' => round($total, 1),
            'comments' => $myRates->pluck('comment'),
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
                Rule::exists('users', 'id')->where(function ($query) {
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
                Rule::exists('users', 'id')->where(function ($query) {
                    $query->where('type', UserTypeEnum::COMPANY);
                })
            ],
            'rate' => ['required', 'numeric', 'min:1', 'max:5'],
        ]);

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
                Rule::exists('users', 'id')->where(function ($query) {
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
                Rule::exists('users', 'id')->where(function ($query) {
                    $query->where('type', UserTypeEnum::COMPANY);
                })
            ],
            'rate' => ['required', 'numeric', 'min:1', 'max:5'],
        ]);

        $data['employee_id'] = auth('api')->user()->id;
        $rate = RateCompany::findOrFail($rateId);
        $rate->update($data);
        return response()->json(['message' => 'تم تحديث التقييم بنجاح']);
    }
}

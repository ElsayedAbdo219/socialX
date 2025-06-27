<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Models\Member;
use App\Enum\UserTypeEnum;
use Illuminate\Http\Request;
use App\Models\{UserApplyJob, Job};
use App\Http\Controllers\Controller;

class UserApplyJobController extends Controller
{
  public function add(Request $request)
  {
    $data = $request->validate([
      'jobs_applies_id' => 'required|exists:jobs_applies,id',
    ]);
    $data['employee_id'] = auth('api')->user()->id;
    if (auth('api')->user()->UserApplyJob()->where('jobs_applies_id', $data['jobs_applies_id'])->count() > 0) {
      return response()->json(['message' => 'تم اضافة  طلبك من قبل']);
    }
    UserApplyJob::updateOrCreate($data);
    return response()->json(['message' => 'تم اضافة  طلبك بنجاح']);
  }

  public function getDetailsOfAppliers(Request $request, $idJob)
  {
    $paginateSize = $request->query('paginateSize', 10);
    $job = Job::findOrFail($idJob);
    $members = Member::whereHas('UserApplyJob', function ($q) use ($idJob) {
      $q->where('jobs_applies_id', $idJob);
    })->orderBy('created_at', 'desc')->paginate($paginateSize);

    return response()->json($members);
  }
}

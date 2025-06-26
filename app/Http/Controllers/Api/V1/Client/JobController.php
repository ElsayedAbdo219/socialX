<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Models\Job;
use App\Models\User;
use App\Models\Member;
use App\Models\Calender;
use App\Enum\UserTypeEnum;
use App\Models\RateEmployee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\ClientNotification;
use App\Http\Requests\Api\V1\Client\JobRequest;


class JobController extends Controller
{

  public function add(JobRequest $request)
  {
    $data = $request->validated();
    $data['member_id'] = auth('api')->user()->id;
    $ss = [];
    foreach ($data['job_description'] as $job_desc) {
      $ss[] = $job_desc;
    }
    $data['job_description'] = $ss;
    $Job = Job::create($data);
    # sending a notification to the user   
    $notifabels = User::first();
    $notificationData = [
      'title' => " اضافة وظيفة جديدة ",
      'body' => "  تم اضافة وظيفة"  . $data['job_name'] . ' من '  . auth("api")->user()->full_name,
    ];

    \Illuminate\Support\Facades\Notification::send(
      $notifabels,
      new ClientNotification($notificationData, ['database', 'firebase'])
    );
    return response()->json(['message' => 'تم اضافة وظيفة  جديدة بنجاح', 'Job' => $Job]);
  }


  public function update(JobRequest $request, Job $job)
  {
    $data = $request->validated();
    $ss = [];
    foreach ($data['job_description'] as $job_desc) {
      $ss[] = $job_desc;
    }
    $data['job_description'] = $ss;
    $job->update($data);
    # sending a notification to the user
    $notifabels = User::first();
    $notificationData = [
      'title' => " تحديث وظيفة ",
      'body' => "  تم تحديث وظيفة"  . $data['job_name'] . ' من '  . auth("api")->user()->full_name,
    ];

    \Illuminate\Support\Facades\Notification::send(
      $notifabels,
      new ClientNotification($notificationData, ['database', 'firebase'])
    );
    return response()->json(['message' => 'تم تحديث وظيفة  بنجاح', 'Job' => $job]);
  }

  public function delete(Job $job)
  {
    $job->delete();
    return response()->json(['message' => 'تم حذف الوظيفة بنجاح']);
  }


  public function get(Job $job)
  {
    return response()->json(['Job' => $job]);
  }

  public function getCompanyJobs(Request $request, $member)
  {
    $paginateSize = $request->query('paginateSize', 10);
    $member = Member::where('id', $member)->first();
    return $member?->jobs()->OfStatus(1)->paginate($paginateSize);
  }

  public function setCompletedJob(Job $job)
  {
    $job->update(['is_active' => 0]);
    # sending a notification to the user
    $notifabels = User::first();
    $notificationData = [
      'title' => " اكمال وظيفة ",
      'body' => "  تم اكمال وظيفة"  . $job->job_name . ' من '  . auth("api")->user()->full_name,
    ];

    \Illuminate\Support\Facades\Notification::send(
      $notifabels,
      new ClientNotification($notificationData, ['database', 'firebase'])
    );
    return response()->json(['message' => 'تم اكمال الوظيفة بنجاح']);
  }


  public function getAllJobs(Request $request)
  {
    $paginateSize = $request->query('paginateSize', 10);
    $jobs = Job::OfStatus(1)
      ->when($request->query("employee_type"), function ($query, $value) {
        return $query->where('employee_type', 'like', "%$value%");
      })
      ->when($request->query("work_mode"), function ($query, $value) {
        return $query->where('work_mode', 'like', "%$value%");
      })
      ->when($request->query("job_category"), function ($query, $value) {
        return $query->where('job_category', 'like', "%$value%");
      })
      ->when($request->query("job_name"), function ($query, $value) {
        return $query->where('job_name', 'like', "%$value%");
      })
      ->when($request->query("work_level"), function ($query, $value) {
        return $query->where('work_level', 'like', "%$value%");
      })
      ->when($request->query("salary"), function ($query, $value) {
        return $query->where('salary', '>=', (float) $value);
      })
      ->when($request->query("salary_period"), function ($query, $value) {
        return $query->where('salary_period', 'like', "%$value%");
      })
      ->when($request->query("experience"), function ($query, $value) {
        return $query->where('experience', 'like', "%$value%");
      })
      ->when($request->query("job_period"), function ($query, $value) {
        return $query->where('job_period', 'like', "%$value%");
      })
      ->when($request->query("location"), function ($query, $value) {
        return $query->where('location', 'like', "%$value%");
      })
      ->when($request->query("overview"), function ($query, $value) {
        return $query->where('overview', 'like', "%$value%");
      })
      ->when($request->query("job_description"), function ($query, $value) {
        return $query->whereJsonContains('job_description', $value);
      })
      ->when($request->query("created_at"), function ($query, $value) {
        if($value == 'asc') {
          return $query->orderBy('created_at', 'asc');
        } elseif($value == 'desc') {
          return $query->orderBy('created_at', 'desc');
        }
        return $query->whereDate('created_at', $value);
      })

      ->paginate($paginateSize);
    return response()->json(['jobs' => $jobs]);
  }

  public function getMyJobs(Request $request)
  {
    $paginateSize = $request->query('paginateSize', 10);
    $user = auth('api')->user();
    if ($user->type == UserTypeEnum::COMPANY) {
      $member = Member::where('id', $user->id)->first();
      return $member?->jobs()->paginate($paginateSize);
    }
    return response()->json(['message' => 'لا يوجد وظائف خاصة بك'], 404);
  }

  public function getMyJob(Job $job)
  {
    $user = auth('api')->user();
    if ($user->type == UserTypeEnum::COMPANY) {
      $member = Member::where('id', $user->id)->first();
      if ($member && $member->id == $job->member_id) {
        return response()->json(['job' => $job]);
      }
    }
    return response()->json(['message' => 'لا يوجد وظيفة خاصة بك'], 404);
  }

  public function  getTopRated(Request $request)
  {
    $paginateSize = $request->query('paginateSize', 10);
    // return  RateEmployee::with('employee')->get();
    return RateEmployee::when($request->query("location"),function($query,$value){
       return $query->whereHas('employee.experience', function ($q) use ($value) {
          $q->where('city', 'like', "%$value%")->orWhere('country', 'like', "%$value%");
      });

    })->get()
      ->groupBy('employee_id')
      ->map(function ($rates) {
        return [
          'rates' => $rates->avg('rate'),
          'employee' => $rates->first()->employee
        ];
      })
      ->sortDesc()
      ->customPaginate($paginateSize);
  }
  public function getSomeData()
  {
    return [
       'companies' => Member::where('type', UserTypeEnum::COMPANY)->count(),
       'employees' => Member::where('type', UserTypeEnum::EMPLOYEE)->count(),
       'users' => Member::count(),
       'jobs' => Job::OfStatus(1)->count(),
       'allEvents' => Calender::where('member_id', auth('api')->id())->count(),
       'unCompletedEvents' => Calender::where('member_id', auth('api')->id())->where('status', '!=', 'completed')->count(),
       'completedEvents' => Calender::where('member_id', auth('api')->id())->where('status', 'completed')->count(),
    ];
  }
}

<?php

namespace App\Http\Controllers\Dashboard;
use App\Models\Job;
use Illuminate\Http\Request;

use App\Datatables\JobDatatable;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponseDashboard;

class JobController extends Controller
{

  use ApiResponseDashboard;


  
    protected string $datatable = JobDatatable::class;
    protected string $route = 'admin.jobs';
    protected string $viewPath = 'dashboard.jobs.list';

    
    public function index ()
    {
        return $this->datatable::create($this->route)
        ->render($this->viewPath);

    }


    public function edit($job)
    {
      $job=Job::findOrFail($job);
      return view(
        "dashboard.jobs.edit",
        [
          "job" => $job,
        ]
      );
    }
  
    public function update(Request $request, $job)
    {
      $job=Job::findOrFail($job);
      $data = $request->validate([
          'is_Active'=>"required|string",
      ]);
     
      $job->update($data);
      return redirect()->route('admin.jobs.index')->with(['success',__('dashboard.item updated successfully')]);
      
    }



    public function destroy(Job $job)
    {
        $job->delete();
        if (request()->expectsJson()){
            return self::apiCode(200)->apiResponse();
        }
        return redirect()->route('admin.companies.index')->with('success',__('dashboard.item deleted successfully'));
    }

}

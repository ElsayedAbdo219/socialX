<?php

namespace App\Http\Controllers\Dashboard;
use Illuminate\Http\Request;
use App\Models\Job;

use App\Datatables\JobDatatable;
use App\Http\Controllers\Controller;

class JobController extends Controller
{
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
      $request->validate([
          'job_balance'=>"required|string",
          'job_ton'=>"required|string",
      ]);
     
      $job->update([
          'job_balance'=>$request->job_balance,
          'job_ton'=>$request->job_ton,
      ]);
      return redirect()->route('admin.jobs.index')->with(['success',__('dashboard.item updated successfully')]);
      
    }

}

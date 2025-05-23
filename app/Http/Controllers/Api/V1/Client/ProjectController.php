<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Api\V1\Client\ProjectRequest;
use App\Models\Project;
class ProjectController extends Controller
{
     use ApiResponseTrait;

    public function  all(Request $request)
    {
        $paginateSize = $request->query('paginateSize', 2);
        return Project::where('user_id',auth('api')->id())->paginate($paginateSize);
    }

    public function  show($Project_Id)
    {
        return Project::where('id',$Project_Id)->first();
    }

    public function add(ProjectRequest $request)
    {
        $dataValidateRequest = $request->validated();
        $dataValidateRequest['user_id'] = auth('api')->id();
        Project::create($dataValidateRequest);
        return $this->respondWithSuccess('Project Added Successfully!');
    }
   
    public function  update(ProjectRequest $request,$Project_Id)
    {
        $Project = Project::find($Project_Id);
        if(is_null($Project)){
           return $this->respondWithError('Project Not Found,try Again!!');
        }
        $dataValidateRequest = $request->validated();
        $dataValidateRequest['user_id'] = auth('api')->id();
        $Project->update($dataValidateRequest);
        return $this->respondWithSuccess('Project Updated Successfully!');
    }

    public function  delete($Project_Id)
    {
        Project::where('id',$Project_Id)->delete();
        return $this->respondWithSuccess('Project Deleted Successfully!');
    }

    public function  getProjects(Request $request,$User_Id)
    {
        $paginateSize = $request->query('paginateSize', 2);
        return Project::where('user_id',$User_Id)->paginate($paginateSize);
    }



}

<?php

namespace App\Http\Controllers\Api\V1\Client;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CommonQuestion;
use App\Http\Resources\Api\V1\Client\{CommonQuestionResource};

class CommonQuestionController extends Controller
{

    public function view(){
     $commonQuestions=CommonQuestion::orderBy('order','asc')->get();
     $collection = CommonQuestionResource::collection($commonQuestions)->customPaginate(20);
     return $collection;
     
    }
}

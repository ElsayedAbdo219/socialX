<?php

namespace App\Http\Controllers\Api\V1\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
class NewsController extends Controller
{
    public function index()
    {
        $news  = News::orderBy('id','desc')->limit(10)->get() ;
        return response()->json(['news'=>$news ,'yesCount' => News::where('yes',1)->count(),'noCount' => News::where('no',1)->count() ]);
        // ['yesCount' => News::where('yes',1)->count()],['noCount' => News::where('no',1)->count()]
    }

    public function yes($id)
    {
         News::find($id)?->updateOrCreate(
            
            [
                'user_id' => auth('api')->user()->id
            ]
            
            ,
            [

            'yes' => 1
            
            
            ]
        
        
        );
         

        return response()->json(['message' => 'تم اضافة استطلاعك بنجاح']);
    }


    public function no($id)
    {
        
         News::find($id)?->updateOrCreate(
             [

                'user_id' => auth('api')->user()->id
            ]
            
            ,


            [
                
            'no' => 1
            
            
            ]
        
        );

        return response()->json(['message' => 'تم اضافة استطلاعك بنجاح']);
    }
    
}

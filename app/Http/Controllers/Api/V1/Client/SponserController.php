<?php
namespace App\Http\Controllers\Api\V1\Client;

use App\Models\Sponser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SponserResource;
class SponserController extends Controller
{
    public function index(Request $request)
    {
      $paginateSize = $request->query('paginateSize', 10);
       return Sponser::select('id','image','user_id')
            ->with('company')
            ->paginate($paginateSize);
        // return SponserResource::collection(Sponser::select('id','image','user_id')->with('user')->paginate($paginateSize));
    }

}

<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    UserCover,
    Member
};
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class UserCoverController extends Controller
{
     use ApiResponseTrait;


      public function  show(Request $request)
    {
        $request->validate([
            'member_id' => ['required','exists:members,id' ],
           ]);

           return UserCover::where('member_id',$request['member_id'])->get();

    }

    public function add(Request $request)
    {
       $request->validate([
        'image' => ['required','image' ,'mimes:jpg,jpeg,png,gif'],
        'is_primary' => ['nullable','in:0,1' ],
       ]);

       DB::beginTransaction();

       $member = Member::find( auth('api')->user()->id  );
    //    dd($member);

      if($member->userCover->count() >= 3 )
       {
         throw new \Exception('أقصي عدد للصور هو 3 صور');
       }

      if($request['is_primary'] == 1 && $member?->userCover->count() > 0 && $member?->userCover?->where('is_primary',1)->first()?->exists())
        {
            $member?->userCover?->where('is_primary',1)->first()->update(['is_primary' => 0 ]);
        }

      
       $imageName = basename(Storage::disk('public')->put('user-covers', $request['image'] ));

       $userCover = UserCover::create(
        [
          'member_id' => auth('api')->user()->id,
          'image' => $imageName,
          'is_primary' => $request['is_primary'],
        ]
        );

        DB::commit();

        return $this->respondWithSuccess('userCover Added Successfully', ['userCover' => $userCover ]);
    }
   
    public function  update(Request $request)
    {
        $request->validate([
            'id' => ['required','exists:user_covers,id' ],
            'image' => ['nullable','image' ,'mimes:jpg,jpeg,png,gif'],
            'is_primary' => ['nullable','in:0,1' ],
           ]);
    
           DB::beginTransaction();

           $userCover = UserCover::find($request['id']);
           $member = Member::find( auth('api')->user()->id  );
          
 
       if($request['is_primary'] == 1 && $member?->userCover->count() > 0 && $member?->userCover?->where('is_primary',1)->first()?->exists())
        {
            $member?->userCover?->where('is_primary',1)->first()->update(['is_primary' => 0 ]);
        }

           if(!empty($request['image']))
           {
            Storage::delete('public/user-covers/'.$userCover?->image );
            $imageName = basename(Storage::disk('public')->put('user-covers', $request['image'] ));
           }
            # UPDATE
           $userCover->update(
            [
                'image' => $imageName ?? $userCover?->image ,
                'is_primary' => $request['is_primary'],
            ]
            );
    
            DB::commit();
    
            return $this->respondWithSuccess('userCover Updated Successfully', ['userCover' => $userCover ] );
    }

    public function  delete(Request $request)
    {
        $request->validate([
            'id' => ['required','exists:user_covers,id' ],
           ]);
           
        DB::beginTransaction();
        $userCover = UserCover::find($request['id']);
        Storage::delete('public/user-covers/'.$userCover?->image );
        UserCover::where('id',$request['id'])->delete();
        DB::commit();
        return $this->respondWithSuccess('userCover Deleted Successfully');
    }


    public function  updateTheCurrentPrimary(Request $request)
    {
        $request->validate([
            'id' => ['required','exists:user_covers,id' ],
            'is_primary' => ['nullable','in:0,1' ],
           ]);
           $member = Member::find( auth('api')->user()->id  );

      if($request['is_primary'] == 1 && $member?->userCover->count() > 0 && $member?->userCover?->where('is_primary',1)->first()?->exists())
        {
            $member?->userCover?->where('is_primary',1)->first()->update(['is_primary' => 0 ]);
        }

           $userCover = UserCover::find($request['id']);
            # UPDATE
           $userCover->update(
            [
                'is_primary' => $request['is_primary'],
            ]
            );
    
            return $this->respondWithSuccess('userCover Updated Successfully', ['userCover' => $userCover ] );
    }

}

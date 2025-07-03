<?php
namespace App\Http\Controllers\Dashboard;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemberController extends Controller
{
  
  public function changeVerificationStatus(Request $request)
    {
      \Log::info($request);
      
        $request->validate([
            'value' => 'required|in:0,1',
            'user_id' => 'required|exists:members,id',
        ]);

        $user = Member::find($request->user_id);
        $user->verfication_account = $request->value;
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Verification status updated successfully.',
        ]);
    }

}

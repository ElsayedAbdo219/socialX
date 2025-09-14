<?php

namespace App\Http\Controllers\Dashboard;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\Member;
use App\Models\AdsStatus;
use App\Enum\AdsStatusEnum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponseDashboard;
use App\Datatables\AdvertiseDatatable;
use Illuminate\Support\Facades\Storage;
use App\Notifications\ClientNotification;
use App\Http\Requests\Dashboard\UpdateStatusAdvertise;

class AdvertiseController extends Controller
{
  use ApiResponseDashboard;



  protected string $datatable = AdvertiseDatatable::class;
  protected string $route = 'admin.advertises';
  protected string $viewPath = 'dashboard.advertises.list';


  public function index()
  {
    return $this->datatable::create($this->route)
      ->render($this->viewPath);
  }



  public function create()
  {

    $companies = Member::where('type', 'company')->get();

    return view('dashboard.advertises.add', [
      'companies' => $companies
    ]);
  }

  public function store(Request $request)
  {
    $data = $request->validate([
      'content' => 'nullable|string|max:255',
      'user_id' => 'required|exists:members,id',
      'period' => 'required|numeric',
      'is_published' => 'required|numeric',
      'file_name' => 'image|mimes:jpeg,png,jpg',

    ]);
    $data['status'] = 'advertise';
    $post = Post::create($data);
    $post->adsStatus()->create([
      'status' => AdsStatusEnum::PENDING,
    ]);

    if ($request->file('file_name')) {
      $file = $request->file('file_name');
      $file_name = uniqid() . '_' . $file->getClientOriginalName();
      $filePath = $file->storeAs('companies', $file_name);
      $post->update([
        'file_name' => $file_name,
      ]);
    }
    # sending a notification to the user   
    $notifabels = Member::where('id', $data['user_id'])->first();
    $notificationData = [
      'title' => " اضافة اعلان جديدة ",
      'body' => "تم اضافة اعلان لك من ثقه ",
      'type' => 'advertise',
      'id_link' => $post->id,
    ];

    \Illuminate\Support\Facades\Notification::send(
      $notifabels,
      new ClientNotification($notificationData, ['database', 'firebase'])
    );

    return redirect()->route('admin.advertises.index')->with(['success', __('dashboard.item added successfully')]);
  }

  public function edit(Post $Advertise)
  {
    $adsStatus = AdsStatusEnum::PendingAndCancelled();
    // dd($Advertise?->adsStatus);
    return view(
      'dashboard.advertises.edit',
      [
        'Advertise' => $Advertise,
        'adsStatus' => $adsStatus,
      ]

    );
  }

  public function update(UpdateStatusAdvertise $request, $AdvertiseId)
  {
    // dd($request->all());
    $request->validated();
    $Advertise = Post::where('id', $AdvertiseId)->first();

    if (!$Advertise) {
      return redirect()->back()->withErrors(['error' => 'ad$Advertise not found']);
    }
    $Advertise->adsStatus()->updateOrCreate(
      ['ads_id' => $AdvertiseId],
      [
        'status' => $request->status,
        'reason_cancelled' => $request->reason_cancelled ?? null,
      ]
    );
    return match ($request->status) {
      AdsStatusEnum::PENDING => $this->pending($Advertise),
      // AdsStatusEnum::APPROVED => $this->approved($Advertise),
      AdsStatusEnum::CANCELLED => $this->cancelled($Advertise),
      default => null,
    };

  
  }
    # function pending the post
  public function pending($Advertise)
  {
    $notifabels = Member::where('id', $Advertise->user_id)->first();
    if ($notifabels) {
      $notificationData = [
        'title' => " اعلان جديد فالانتظار",
        'body' => "تم تحديث اعلان لك من ثقة فالانتظار ",
        'type' => 'advertise',
        'id_link' => $Advertise->id,
      ];

      \Illuminate\Support\Facades\Notification::send(
        $notifabels,
        new ClientNotification($notificationData, ['database', 'firebase'])
      );
    }
      return redirect()->route('admin.advertises.index')->with(['success', __('dashboard.item updated successfully')]);

  }

  // # function pending the post
  // public function approved($Advertise)
  // {
  //   $notifabels = Member::where('id', $Advertise->user_id)->first();
  //   if ($notifabels) {
  //     $notificationData = [
  //       'title' => " اعلان جديد فالانتظار",
  //       'body' => "تم تحديث اعلان لك من ثقة فالانتظار ",
  //       'type' => 'advertise',
  //       'id_link' => $Advertise->id,
  //     ];

  //     \Illuminate\Support\Facades\Notification::send(
  //       $notifabels,
  //       new ClientNotification($notificationData, ['database', 'firebase'])
  //     );
  //   }
  //     return redirect()->route('admin.advertises.index')->with(['success', __('dashboard.item updated successfully')]);

  // }

  # function cancelled the post
  public function cancelled($Advertise)
  {
    $notifabels = Member::where('id', $Advertise->user_id)->first();
    if ($notifabels) {
      $notificationData = [
        'title' => "رفض اعلان",
        'body' => "تم رفض اعلان لك من ثقه",
        'type' => 'advertise',
        'id_link' => $Advertise->id,
      ];

      \Illuminate\Support\Facades\Notification::send(
        $notifabels,
        new ClientNotification($notificationData, ['database', 'firebase'])
      );
    }
      return redirect()->route('admin.advertises.index')->with(['success', __('dashboard.item updated successfully')]);
  }


  public function destroy(Post $post)
  {
    $post->delete();
    Storage::disk('public')->delete('posts/' . $post->file_name);
    if (request()->expectsJson()) {
      return self::apiCode(200)->apiResponse();
    }
    return redirect()->route('admin.advertises.index')->with('success', __('dashboard.item deleted successfully'));
  }
}

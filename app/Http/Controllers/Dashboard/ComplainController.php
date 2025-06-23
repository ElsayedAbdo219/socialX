<?php

namespace App\Http\Controllers\Dashboard;

use App\Datatables\ComplainDatatable;
use App\Models\Complain;
use App\Traits\ApiResponseDashboard;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\ClientNotification;

class ComplainController extends Controller
{
    use ApiResponseDashboard;

    protected string $datatable = ComplainDatatable::class;
    protected string $routeName = 'admin.complain';
    protected string $viewPath = 'dashboard.complains.list';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->datatable::create($this->routeName)
            ->render($this->viewPath);
    }

        /**
     * Show the form for editing the specified resource.
     */
    public function edit(Complain $complain)
    {
        return view('dashboard.complains.edit', compact('complain'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Complain $complain)
    {
        $validated = $request->validate([
            'status' => ['required','string','in:processing,solved,unsolved']
        ]);
        $complain->update($validated);
        
        if( in_array($validated['status'], ['solved','processing']) ){
            $notifabels = $complain->user;
            $notificationData = [
            'title' => __('dashboard.complain update') . ' '. $complain->id,
            ];
            if($validated['status'] == 'solved'){
                $notificationData['body'] = __('dashboard.solved complaint with number'). ' '. $complain->id;
            } else if ($validated['status'] == 'processing' ){
                $notificationData['body'] = __('dashboard.processing complaint with number'). ' '. $complain->id;
            }
            # sending a notification to the user
             \Illuminate\Support\Facades\Notification::send($notifabels,
             new ClientNotification($notificationData, ['database', 'firebase']));
        } 
        if (request()->expectsJson()){
            return self::apiCode(200)->apiResponse();
        }
        
        return redirect()->route('admin.complain.index')->with('success',__('dashboard.item updated successfully'));
    }

    public function destroy(Complain $complain)
    {
        $complain->delete();
        if (request()->expectsJson()) {
            return self::apiCode(200)->apiResponse();
        }
        return redirect()->route('admin.complain.index')->with('success', __('dashboard.item deleted successfully'));
    }
}
<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MerchantCategory;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $user = auth()->user();
        return view('dashboard.profile.edit',[ 'user' => $user]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function updatePersonal(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'string|required|max:255',
            'email' => 'string|email|required|max:255',
        ]);

        $request->user()->update($validated);

        return redirect()->route('admin.home')->with('success', __('dashboard.personal-updated'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function updatePassword(Request $request, User $user)
    {
        $user = auth()->user();
        $currentPassword = $request->input('current_password');
        if ( !(Hash::check($currentPassword,auth()->user()->password))){
            return throw ValidationException::withMessages([
                'current_password' => [__('dashboard.false_password')]
            ]);
        } else {
            $validated = $request->validate( [
                'password' => ['required', 'string', 'confirmed', Password::defaults()],
            ] );
            $user->update([
                'password' => $validated['password']
            ]);
            return redirect()->route('admin.home')->with('success', __('dashboard.password-updated'));
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // 
    }
} 
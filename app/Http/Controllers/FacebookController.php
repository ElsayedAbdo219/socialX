<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class FacebookController extends Controller
{
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->stateless()->user();

            $user = User::firstOrCreate([
                'email' => $facebookUser->getEmail(),
            ], [
                'name' => $facebookUser->getName(),
                'facebook_id' => $facebookUser->getId(),
                'avatar' => $facebookUser->getAvatar(),
            ]);

            Auth::login($user, true);

            return redirect()->intended('dashboard');
        } catch (\Exception $e) {
            return redirect('auth/facebook');
        }
    }
}

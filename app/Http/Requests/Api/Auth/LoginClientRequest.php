<?php

namespace App\Http\Requests\Api\Auth;

use App\Enum\UserTypeEnum;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

/**
 * @bodyParam mobile string required The Mobile Number of the user.Example: 0564777888
 * @bodyParam password string required The password of User account.Example: 12345678
 */
class LoginClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
      // dd('here');
        return [
            'email' => ['required','email:filter' ,  Rule::exists('members', 'email')],
            'password' => ['required', 'string', Password::default()],
        ];
    }

    /* public function attributes(): array
    {
        return [
            'mobile' => __('Mobile'),
            'password' => __('Password'),
        ];
    } */

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
   /*  public function authenticate()
    {
        $this->ensureIsNotRateLimited();
        $data = $this->only('mobile', 'password');
        if (!Auth::attempt($data, $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'mobile' => __("Wrong Credentials"),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }
 */
    /**
     * Ensure the login request is not rate limited.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited()
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'mobile' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string
     */
    public function throttleKey()
    {
        return $this->ip();
    }
}

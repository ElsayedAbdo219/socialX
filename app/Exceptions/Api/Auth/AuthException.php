<?php

namespace App\Exceptions\Api\Auth;

use App\Exceptions\Api\Auth\ApiBaseException;

class AuthException extends ApiBaseException
{
    public static function userNotFound($errors, $code = null)
    {
        return new self($errors, __("User Data Not Found"), $code ?? 404);
    }

    public static function otpNotGenerated($errors, $code = null)
    {
        return new self($errors, __("Failed Operation"), $code ?? 500);
    }

    public static function userFailedRegistration($errors, $code = null)
    {
        return new self($errors, __("Failed Operation"), $code ?? 500);
    }

    public static function userFailedLogin($errors, $code = null, $message = null)
    {
        $message = $message ?? __("Wrong Credentials");
        return new self($errors, $message, $code ?? 400);
    }

    public static function accountStatusDeactive($errors, $code = null)
    {
        return new self($errors, __("Failed Operation"), $code ?? 401);
    }
}

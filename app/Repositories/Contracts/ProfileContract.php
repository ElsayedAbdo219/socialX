<?php

namespace App\Repositories\Contracts;

interface ProfileContract extends BaseContract
{
    public function updateAccountPassword($request): bool;
    public function updateProfile($request): mixed;
    public function verifyOTP($request): bool;


}

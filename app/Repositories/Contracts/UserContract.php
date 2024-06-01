<?php

namespace App\Repositories\Contracts;

use App\Models\User;

interface UserContract extends BaseContract
{
    public function relatedData(User $model);
}

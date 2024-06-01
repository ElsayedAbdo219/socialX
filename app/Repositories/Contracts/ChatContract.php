<?php

namespace App\Repositories\Contracts;

use App\Models\Chat;

interface ChatContract extends BaseContract
{
    public function relatedData(Chat $model);
}

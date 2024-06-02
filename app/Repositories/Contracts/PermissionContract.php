<?php

namespace App\Repositories\Contracts;

use App\Models\Permission;

interface PermissionContract extends BaseContract
{
    public function relatedData(Permission $model);
}

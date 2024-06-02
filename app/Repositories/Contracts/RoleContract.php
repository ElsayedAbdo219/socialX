<?php

namespace App\Repositories\Contracts;

use App\Models\Role;

interface RoleContract extends BaseContract
{
    public function relatedData(Role $model);
}

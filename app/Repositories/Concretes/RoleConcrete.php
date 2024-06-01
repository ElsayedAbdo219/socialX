<?php

namespace App\Repositories\Concretes;

use App\Models\Role;
use App\Repositories\Contracts\RoleContract;

class RoleConcrete extends BaseConcrete implements RoleContract
{
    /**
     * RoleRepository constructor.
     * @param Role $model
     */
    public function __construct(Role $model)
    {
        parent::__construct($model);
    }

    /**
     * Check if model has relations with any other tables
     * @param Role $model
     * @return int
     */
    public function relatedData(Role $model)
    {
        return 0;
    }
}

<?php

namespace App\Repositories\Concretes;

use App\Models\Role;
use App\Models\User;
use App\Repositories\Contracts\RoleContract;
use App\Repositories\Contracts\UserContract;

class UserConcrete extends BaseConcrete implements UserContract
{
    /**
     * RoleRepository constructor.
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    /**
     * Check if model has relations with any other tables
     * @param User  $model
     * @return int
     */
    public function relatedData(User $model)
    {
        return 0;
    }
}

<?php

namespace App\Repositories\Concretes;

use App\Models\Chat;
use App\Repositories\Contracts\ChatContract;

class ChatConcrete extends BaseConcrete implements ChatContract
{
    /**
     * RoleRepository constructor.
     * @param Chat $model
     */
    public function __construct(Chat $model)
    {
        parent::__construct($model);
    }

    /**
     * @param Chat $model
     * @return int
     */
    public function relatedData(Chat $model)
    {
        return 0;
    }
}

<?php

namespace App\Repositories\Concretes;

use App\Models\Setting;
use App\Repositories\Contracts\SettingContract;

class SettingConcrete extends BaseConcrete implements SettingContract
{
    /**
     * @param Setting $model
     */
    public function __construct(Setting $model)
    {
        parent::__construct($model);
    }

    /**
     * @param Setting $model
     * @return int
     */
    public function relatedData(Setting $model)
    {
        return 0;
    }
}

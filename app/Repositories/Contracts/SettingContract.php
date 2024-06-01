<?php

namespace App\Repositories\Contracts;

use App\Models\Setting;

interface SettingContract extends BaseContract
{
    public function relatedData(Setting $model);
}

<?php

namespace App\Repositories\Contracts;

interface ContactUsContract extends BaseContract
{
    public function reply($request, $contactUs);
}

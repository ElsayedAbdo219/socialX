<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Models\Payment;
use App\Models\GoodType;
use App\Enum\UserTypeEnum;
use App\Enum\ContactUsTypesEnum;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Notifications\AdminNotification;
use Illuminate\Support\Facades\Notification;
use App\Http\Requests\Api\V1\Client\ContactUsRequest;
use App\Http\Resources\Api\V1\Dashboard\PaymentResource;
use App\Http\Resources\Api\V1\Dashboard\ContactUsResource;

class StaticPagesController extends Controller
{
 

}

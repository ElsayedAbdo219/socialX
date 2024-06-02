<?php

return [
    "root_key" => "xYQ(CRwey4zva])5W?8huID[6F~EVS@f",
    "private_key" => "KL]#Bm+hv?2,e98DM~$6acRNF[nXzY*w",
    "should_use_api_key_middleware" => env('USE_API_KEY_MIDDLEWARE', false),
    "login_require_otp" => env('AUTH_LOGIN_REQUIRE_OTP', false),
    "set_prefered_locale_home" => env('SET_PREFERED_LOCALE_ON_VISITING_HOME', true),
    "sms" => env('SMS', 'local'),
];

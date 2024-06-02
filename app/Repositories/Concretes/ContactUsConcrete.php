<?php

namespace App\Repositories\Concretes;

use App\Models\ContactUs;
use App\Notifications\ClientNotification;
use App\Repositories\Contracts\ContactUsContract;

class ContactUsConcrete extends BaseConcrete implements ContactUsContract
{
    /**
     * BankConcrete constructor.
     * @param ContactUs $model
     */
    public function __construct(ContactUs $model)
    {
        parent::__construct($model);
    }

    public function reply($request, $contactUs)
    {
        $contactUs->update([
            'respond_message' => $request['respond_message'],
            'is_responded' => true
        ]);

        $notificationData = prepareNotification(
            title: 'messages.responses.respond_message',
            body: ['data' => $contactUs->respond_message,]
        );
        //        dd(json_decode(data_get($notificationData, 'body'), true)['data']);
        $contactUs->user?->notify(new ClientNotification($notificationData, ['mail']));

    }
}

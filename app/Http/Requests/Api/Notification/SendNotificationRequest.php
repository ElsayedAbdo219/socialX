<?php

namespace App\Http\Requests\Api\Notification;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @bodyParam title string required Notification title.Example: title
 * @bodyParam body string required Notification Message.Example: message
 * @bodyParam topic string (optional) Notification Topic.Example: offer
 * @bodyParam roles [] string required.Example: ['all','admin']
 * @bodyParam users [] integer required.Example: [1,2]
 */
class SendNotificationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title_ar' => ['required', 'string'],
            'title_en' => ['required', 'string'],
            'body' => ['required', 'string'],
            'ids' => ['nullable', 'array'],
            'type' => ['required', 'in:client,driver,all'],
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => __('Title'),
            'body' => __('Message'),
            'users' => __('Users'),
        ];
    }
}

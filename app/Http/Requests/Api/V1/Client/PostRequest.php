<?php

namespace App\Http\Requests\Api\V1\Client;

use Illuminate\Foundation\Http\FormRequest;
use App\Enum\PostTypeEnum;
class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $types = implode(',' ,array_keys(PostTypeEnum::toArray()));
        // dd($types);
        return [
            'type' => ['required','in:'.$types],
            'content' => ['required_if:type,'.PostTypeEnum::NORMAL,'string'],
            'file_name' => ['required_if:type,'.PostTypeEnum::ADVERTISE,'file','mimes:jpeg,png,jpg,mp4,avi,mov'],
            // 'period' => ['required_if:type,'.PostTypeEnum::ADVERTISE,'string'],
            // 'is_published' => ['required_if:type,'.PostTypeEnum::ADVERTISE,'string'],
        ];
        // dd(request());

    }
}

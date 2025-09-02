<?php

namespace App\Http\Requests\Api\V1\Client;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
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
        $types = implode(',', array_keys(PostTypeEnum::toArray()));
    
        // $file = $this->file('file_name');
        // $videoExtensions = ['mp4', 'avi', 'mov'];
        // $isVideo = $file && in_array($file->getClientOriginalExtension(), $videoExtensions) && $this->type == PostTypeEnum::ADVERTISE;
    
        return [
            'type' => ['required', 'in:'.$types],
            'content' => ['required_if:type,'.PostTypeEnum::NORMAL, 'string'],
            'file_name' => ['nullable', 'string'],
            'image'  => ['nullable', 'image','mimes:jpg,jpeg,png,wepb'],
            'period' => ['required_if:type,'.PostTypeEnum::ADVERTISE, 'string'],
            'resolution' => ['required_if:type,'.PostTypeEnum::ADVERTISE, 'numeric', 'in:720,1080,1440,2160'],
            'start_time' => ['required_if:type,'.PostTypeEnum::ADVERTISE, 'date_format:H:i'],
            'end_time' => ['required_if:type,'.PostTypeEnum::ADVERTISE, 'date_format:H:i'],
            'start_date' => ['required_if:type,'.PostTypeEnum::ADVERTISE, 'date'],
            'end_date' => ['required_if:type,'.PostTypeEnum::ADVERTISE, 'date'],
            'coupon_code' => ['nullable', 'string'],
            // 'chunk_number' => ['nullable', 'numeric'],
            
        ];
    }
    

}

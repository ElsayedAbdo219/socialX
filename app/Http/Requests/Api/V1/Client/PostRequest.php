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
    
        $file = $this->file('file_name');
        $videoExtensions = ['mp4', 'avi', 'mov'];
        $isVideo = $file && in_array($file->getClientOriginalExtension(), $videoExtensions) && $this->type == PostTypeEnum::ADVERTISE;
    
        return [
            'type' => ['required', 'in:'.$types],
            'content' => ['nullable', 'string'],
            'file_name' => ['nullable', 'mimes:jpeg,png,jpg,mp4,avi,mov'],
            'period' => [Rule::requiredIf($isVideo), 'string'],
            'resolution' => [Rule::requiredIf($isVideo), 'numeric', 'in:720,1080,1440,2160'],
            'start_time' => [Rule::requiredIf($isVideo), 'date_format:H:i'],
            'end_time' => [Rule::requiredIf($isVideo), 'date_format:H:i'],
            'start_date' => [Rule::requiredIf($isVideo), 'date'],
            'end_date' => [Rule::requiredIf($isVideo), 'date'],
            'coupon_code' => ['nullable', 'string'],
        ];
    }
    

}

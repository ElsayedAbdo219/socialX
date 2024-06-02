<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

/**
 * @bodyParam name string required The user personal name.Example: Fahmi Moustafa
 * @bodyParam mobile string required The Mobile Number of the user.Example: 0564776688
 * @bodyParam email string (optional) The E-Mail Address of the user.Example: fahmi@moltaqa.net
 * @bodyParam national_identity string lenght[10] required The user national identity number.Example: 1234567893
 * @bodyParam nationality_id integer required the nationality id.Example: 1
 * @bodyParam dob string required user date of birth formated as Y-m-d.Example: 1990-09-30
 * @bodyParam avatar file required user personal image.
 * @bodyParam password string required The User bew password.Example: 12345678
 * @bodyParam password_confirmation string required The user new password confirmation.Example: 12345678
 * @bodyParam address string required user address.Example: jada - stret 13 - building 5
 * @bodyParam lat number required user lattiude.Example: 31.324342744239
 * @bodyParam long number required userlongitude.Example: 41.37437832442
 * @bodyParam car_category_id integer required user seelcted car type id.Example: 1
 * @bodyParam serial_number string required user car serial number.Example: djkjfbajkdfnlk
 * @bodyParam board_number string required user car board number.Example: Kg8f06
 * @bodyParam car_image file required user car image.
 */
class RegisterDriverRequest extends FormRequest
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
            "name" => ["required","string","max:190"], //
            "mobile" => ["required","unique:users,mobile"], //
            "email" => ["nullable","unique:users,email"], //
            "avatar" => ["required","image","mimes:png,jpg,jpeg"], //

            "id_image" => ["required","image","mimes:png,jpg,jpeg"], //
            "licence_image" => ["required","image","mimes:png,jpg,jpeg"], //
            "password" => ["required","confirmed",Password::default()],
            'code_from_another' => ['nullable'],

            "nationality_id" => ["required","exists:nationalities,id"], //
            "dob" => ["required","date","date_format:Y-m-d"], //
//            "driving_licence_number" => ["required"],

            "address" => ["required","string","max:190"], //
            "lat" => ["required","numeric"], //
            "long" => ["required","numeric"], //

            "car_brand_id" => ["required","exists:car_brands,id"], //
            "car_category_id" => ["required","exists:car_categories,id"], //
            "car_model_id" => ["required","exists:car_models,id"], //
            "car_color_id" => ["required","exists:car_colors,id"], //
            "plate_number" => ["required","string"], //
            "is_owner" => ["required","in:0,1"], //
            "car_authorization_image" => ["required_if:is_owner,0","image","mimes:png,jpg,jpeg"], //
            "car_insurance_image" => ["required","image","mimes:png,jpg,jpeg"], //
            "car_licence_image" => ["required","image","mimes:png,jpg,jpeg"], //
            "car_image" => ["required","image","mimes:png,jpg,jpeg"], //
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => __('Name'),
            'mobile' => __('Mobile'),
            'email' => __('E-Mail'),
            'dob' => __('Date of Birth'),
            'password' => __('Password'),
            'password_confirmation' => __('Password Confirmation'),
            'address' => __('Address'),
            'latitude' => __('Latitude'),
            'longitude' => __('Longitude'),
            'serial_number' => __('Serial Number'),
            'board_number' => __('Board Number'),
            'car_image' => __('Car Image'),
        ];
    }
}

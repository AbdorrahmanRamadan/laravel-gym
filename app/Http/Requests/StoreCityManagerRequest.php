<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCityManagerRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'national_id' => ['unique:city_managers','required','digits:14'],
            'city_id' => ['exists:cities,id'],
            'avatar_image'=>['image','mimes:png,jpg'],
            'name'=>['required'],
            'email'=>['required','unique:users,email','email'],
            'password'=>['required','min:8','max:16']
        ];
    }

    public function messages()
    {
        return [
            'national_id.required' => 'National ID Field Is Required',
            'national_id.digits' => 'ID Length is 14 Digits',
            'national_id.unique'=>'National ID Field Must Be Unique',
            'avatar_image.mimes' => 'Only Allowed Extensions Are png,jpg',
            'avatar_image.image' => ' City Manager image must be an image.',
            'city_id.exists'=>'The Selected City Not Found',
            'name.required' => 'Name Field Is Required',
            'email.required' => 'Email Field Is Required',
            'email.email'=>'Email Field Must Be a valid Email',
            'password.required' => 'Password Field Is Required',
            'password.min' => 'Minimum Password Field Is 8 characters',
            'password.max' => 'Maximum Password Field Is 16 characters',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\User;
use Illuminate\Validation\Rules\Unique;

class UpdateCityManagerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
       return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'national_id' => ['digits:14'],
            'city_id' => ['unique','exists:cities,id'],
            'avatar_image'=>['image','mimes:png,jpg'],
            'email'=>['required',Rule::unique('users','email')->ignore($this->cityManager)],
            'password'=>['min:8','max:16']
        ];
    }

    public function messages()
    {
        return [
            'national_id.digits' => 'ID Length is 14 Digits',
            'avatar_image.mimes' => 'Only Allowed Extensions Are png,jpg',
            'city_id.exists'=>'The Selected City Not Found',
            'name.required' => 'Name Field Is Required',
            'email.required' => 'Email Field Is Required',
            'email.unique'=>'Email Field Must Be Unique',
            'city_id.required' => 'City Field Is Unique',
            'email.email'=>'Email Field Must Be a valid Email',
            'password.required' => 'Password Field Is Required',
            'password.min' => 'Minimum Password Field Is 8 characters',
            'password.max' => 'Maximum Password Field Is 8 characters',
        ];
    }
}

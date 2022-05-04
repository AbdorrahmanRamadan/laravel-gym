<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCityManagerRequest extends FormRequest
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
            'national_id' => ['digits:14'],
            'city_id' => ['unique:cities','exists:cities,id'],
            'city_manager_id'=>['unique:city_managers','exists:users,id'],
            'avatar_image'=>['image','mimes:png,jpg']
        ];
    }

    public function messages()
    {
        return [
            'national_id.digits' => 'ID Length is 14 Digits',
            'city_id.unique'=>'City Field Must Be Unique',
            'city_manager_id.unique' => 'City Manager Must Be Unique',
            'avatar_image.mimes' => 'Only Allowed Extensions Are png,jpg',
            'city_id.exists'=>'The Selected City Not Found',
            'city_manager_id.exists'=>'The Selected Manager Not Found',
        ];
    }
}

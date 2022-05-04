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
            'city_id' => ['unique:cities','exists:cities,id'],
            'city_manager_id'=>['unique:city_managers','exists:users,id'],
            'avatar_image'=>['image','mimes:png,jpg']
        ];
    }

    public function messages()
    {
        return [
            'national_id.required' => 'National ID Field Is Required',
            'national_id.digits' => 'ID Length is 14 Digits',
            'national_id.unique'=>'National ID Field Must Be Unique',
            'city_id.required'=>'City Field Is Required',
            'city_id.unique'=>'City Field Must Be Unique',
            'city_manager_id.unique' => 'City Manager Must Be Unique',
            'city_manager_id.required' => 'City Manager Is Required',
            'avatar_image.mimes' => 'Only Allowed Extensions Are png,jpg',
            'avatar_image.required' => 'Image Field Is Required',
            'city_id.exists'=>'The Selected City Not Found',
            'city_manager_id.exists'=>'The Selected Manager Not Found',
        ];
    }
}

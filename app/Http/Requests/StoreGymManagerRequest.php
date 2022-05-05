<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreGymManagerRequest extends FormRequest
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
            'name'=> ['required','min:3'], 
            'email'=> ['required',Rule::unique('users', 'email')], 
            'password'=> ['required','min:8'],
            'confirm-password' => 'required_with:password|same:password|min:8',
            'profile-image'=> ['image'],
        ];
    }
}

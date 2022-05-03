<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTraineeRequest extends FormRequest
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
        //validate and error messages
        return [
            'name'=> ['required','min:3'], 
            'email'=> ['required',Rule::unique('users', 'email')->ignore($this->user),'email'], 
            'password'=> ['required','min:8'],
            'password_confirmation' => 'required_with:password|same:password|min:8',
            'birth_date'=> ['date'],
            'gender'=> 'in:Male,Female',
            'avatar_image'=> ['image'],
        ];
    }
}


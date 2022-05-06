<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTraineeRequest extends FormRequest
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
            'email'=> ['required','email'],//,Rule::unique('users', 'email')->ignore($this->user)
            'password'=> ['required','min:8'],
            'password_confirmation' => 'required_with:password|same:password|min:3',
            'birth_date'=> ['date'],
            'gender'=> 'in:Male,Female',
            'avatar_image'=> ['image'],
        ];
    }
}

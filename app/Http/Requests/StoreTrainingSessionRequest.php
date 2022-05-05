<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\sessionOverlapping;

class StoreTrainingSessionRequest extends FormRequest
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
        $start_at=$this->start_at;
        $end_at=$this->end_at;
        $gym_id=$this->gym_id;
        return [
            'name'=>'required|min:3',
            'start_at'=>'required|date',
            'end_at'=>['required','after:start_at','date',new sessionOverlapping($start_at,$end_at,$gym_id)],
            'gym_id'=>'required|exists:gyms,id',
        ];
    }
}

<?php

namespace App\Http\Requests;
use App\Models\City;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreGymRequest extends FormRequest
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

<<<<<<< HEAD
            $citiesId = (array) null;
=======
        $citiesId = (array) null;
>>>>>>> 3e23596902a3887f34e8e3794fcf4d1403fa32d9
        foreach (City::all('id') as $city) {
            $citiesId[] = $city['id'];
        }
        return [
            'name'=>['required', 'min:3', Rule::unique('gyms', 'name')->ignore($this->gyms)],
            'cover_image'=>['image','mimeType:png,jpg'],
            'city_id'=>Rule::in($citiesId),
<<<<<<< HEAD
            'cover_image'=>['image','mimes:png,jpg'],

        ];
    }

    public function messages()
    {


        return [

            'cover_image.image'=>' Gym image must be an image.',

        ];
    }
=======


        ];
    }

>>>>>>> 3e23596902a3887f34e8e3794fcf4d1403fa32d9
}

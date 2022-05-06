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

            $citiesId = (array) null;
        foreach (City::all('id') as $city) {
            $citiesId[] = $city['id'];
        }
        return [
            'name'=>['required', 'min:3', Rule::unique('gyms', 'name')->ignore($this->gym)],
            'city_id'=>Rule::in($citiesId),
            'cover_image'=>'mimetypes:image/jpeg,image/jpg',

        ];
    }

}

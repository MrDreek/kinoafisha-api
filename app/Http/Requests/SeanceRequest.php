<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SeanceRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'code' => 'required|integer',
            'movieId' => 'required|integer'

        ];
    }

    public function messages()
    {
        return [
            'code.required' => 'Требуется указать код города',
            'code.integer' => 'Код должен быть числом',
            'movieId.required' => 'Требуется указать id фильма',
            'movieId.integer' => 'id фильма должен быть числом'
        ];
    }
}

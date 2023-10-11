<?php

namespace App\Http\Requests\User;

use App\Enums\UserGenderEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'nickname' => [
                'nullable',
                'string',
                'max:255',
            ],
            'gender' => [
                'required',
                'integer',
                Rule::in(UserGenderEnum::asArray()),
            ],
            'location' => [
                'required',
                'string',
                'max:255',
            ],
            'description' => [
                'nullable',
                'string',
                'min:0',
            ],
        ];
    }
}

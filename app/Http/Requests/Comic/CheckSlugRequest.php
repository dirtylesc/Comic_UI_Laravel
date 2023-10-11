<?php

namespace App\Http\Requests\Comic;

use App\Models\Comic;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CheckSlugRequest extends FormRequest
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
            'slug' => [
                'bail',
                'required',
                'string',
                'filled',
                'max:255',
                Rule::unique('comics')
            ],
        ];
    }
}

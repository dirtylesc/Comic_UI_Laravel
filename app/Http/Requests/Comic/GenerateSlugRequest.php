<?php

namespace App\Http\Requests\Comic;

use App\Models\Comic;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GenerateSlugRequest extends FormRequest
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
                'nullable',
                'string',
                'max:255',
                Rule::unique(Comic::class),
            ],
            'alias' => [
                'nullable',
                'string',
                'max:255',
            ]
        ];
    }
}

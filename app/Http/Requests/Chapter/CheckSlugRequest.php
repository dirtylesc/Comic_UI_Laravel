<?php

namespace App\Http\Requests\Chapter;

use App\Models\Chapter;
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
                'required',
                'string',
                'max:255',
                Rule::unique(Chapter::class)
                    ->where('comic_id', $this->comic_id)
                    ->ignore($this->id),
            ]
        ];
    }
}

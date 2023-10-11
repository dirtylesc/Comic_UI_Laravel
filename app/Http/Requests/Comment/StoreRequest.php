<?php

namespace App\Http\Requests\Comment;

use App\Models\Comic;
use App\Models\Rating;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
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
            'messages' => [
                'required',
                'string',
                'min:1',
            ],
            'image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg',
                'max:2048',
            ],
            'rating_id' => [
                'required',
                'numeric',
                Rule::in(
                    Rating::query()
                        ->pluck('id')
                )
            ],
            'comic_slug' => [
                'required',
                'string',
                Rule::in(
                    Comic::query()
                        ->pluck('slug')
                )
            ],
        ];
    }
}

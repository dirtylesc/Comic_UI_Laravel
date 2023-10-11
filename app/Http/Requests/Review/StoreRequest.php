<?php

namespace App\Http\Requests\Review;

use App\Enums\ComicStatusEnum;
use App\Models\Comic;
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
            'rate' => [
                'required',
                'numeric',
                'min:1',
                'max:5',
            ],
            'messages' => [
                'required',
                'string',
                'min:140',
            ],
            'image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg',
                'max:2048',
            ],
            'comic_id' => [
                'required',
                'numeric',
                Rule::in(
                    Comic::query()
                        ->pluck('id')
                        ->where('status', '!=', ComicStatusEnum::PENDING)
                        ->toArray()
                )
            ],
            'comic_slug' => [
                'required',
                'string',
                Rule::in(
                    [Comic::query()
                        ->select('slug')
                        ->where('id', $this->comic_id)
                        ->first()
                        ->slug]
                )
            ],
        ];
    }
}

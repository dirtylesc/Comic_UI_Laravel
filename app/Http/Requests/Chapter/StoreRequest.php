<?php

namespace App\Http\Requests\Chapter;

use App\Enums\UserRoleEnum;
use App\Models\Chapter;
use App\Models\Comic;
use App\Models\User;
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
            'title' => [
                'required',
                'string',
                'max:255',
            ],
            'number' => [
                'required',
                'numeric',
                'min:0',
            ],
            'comic_id' => [
                'required',
                'integer',
                Rule::in(Comic::query()->pluck('id')->toArray()),
            ],
            'comic_slug' => [
                'required',
                'string',
                Rule::in(Comic::query()->pluck('slug')->toArray()),
            ],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique(Chapter::class)
                    ->where('comic_id', $this->comic_id),
            ],
            'images' => [
                'required',
                'array',
            ],
        ];
    }
}

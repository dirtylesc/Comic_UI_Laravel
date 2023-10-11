<?php

namespace App\Http\Requests\Comic;

use App\Enums\BrowseSortEnum;
use App\Enums\ComicStatusEnum;
use App\Enums\TimeTypeRankingEnum;
use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetComicForStoriesRequest extends FormRequest
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
            'category' => [
                'required',
                'string',
                function () {
                    if ($this->category === 'all') {
                        return true;
                    } else Rule::in(Category::query()->pluck('slug')->toArray());
                },

            ],
            'status' => [
                'required',
                'integer',
                Rule::in([-1, ComicStatusEnum::COMPLETED, ComicStatusEnum::ONGOING]),
            ],
            'sort' => [
                'required',
                'integer',
                Rule::in(BrowseSortEnum::getValues()),
            ],
            'timeType' => [
                'required',
                'integer',
                Rule::in(TimeTypeRankingEnum::getValues()),
            ],
            'search' => [
                'nullable',
                'string',
                'max:255'
            ],
            'page' => [
                'nullable',
                'integer',
                'min:1'
            ]
        ];
    }
}

<?php

namespace App\Http\Requests\Comic;

use App\Enums\RankNameRankingEnum;
use App\Enums\TimeTypeRankingEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetComicForRankingRequest extends FormRequest
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
            'rankName' => [
                'required',
                'string',
                Rule::in(RankNameRankingEnum::getValues()),
            ],
            'timeType' => [
                'required',
                'numeric',
                Rule::in(TimeTypeRankingEnum::getValues()),
            ],
            'page' => [
                'required',
                'numeric',
                'min:0',
            ]
        ];
    }
}

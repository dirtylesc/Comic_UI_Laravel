<?php

namespace App\Http\Requests\Comic;

use App\Enums\ComicLanguageEnum;
use App\Enums\ComicStatusEnum;
use App\Enums\UserRoleEnum;
use App\Models\Category;
use App\Models\User;
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
                'bail',
                'required',
                'filled',
                'string',
                'max:255',
            ],
            'alias' => [
                'bail',
                'nullable',
                'max:255',
            ],
            'author' => [
                'bail',
                'nullable',
                'max:255',
            ],
            'name' => [
                'bail',
                'required',
                'filled',
                'string',
                'max:255',
            ],
            'language' => [
                'bail',
                'required',
                Rule::in(ComicLanguageEnum::asArray())
            ],
            'avatar' => [
                'bail',
                'nullable',
                'file',
                'image',
            ],
            'description' => [
                'bail',
                'nullable',
                'string',
                'max:500',
            ],
            'status' => [
                'bail',
                'required',
                Rule::in(ComicStatusEnum::asArray())
            ],
            'user_id' => [
                'required',
                'integer',
                Rule::in(
                    User::query()
                        ->join('team_users', 'team_users.user_id', '=', 'users.id')
                        ->join('teams', 'teams.id', '=', 'team_users.team_id')
                        ->where('role', '=', UserRoleEnum::TRANSLATOR)
                        ->where('teams.user_id', '=', user()->id)
                        ->pluck('users.id')
                        ->toArray()
                ),
            ],
            'categories' => [
                'nullable',
                'array',
                Rule::in(Category::query()->pluck('id')->toArray())
            ],
            'slug' => [
                'bail',
                'required',
                'string',
                'max:255',
            ],
        ];
    }
}

<?php

namespace App\Http\Requests\TeamUsers;

use App\Enums\UserRoleEnum;
use App\Models\Language;
use App\Models\Teams;
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
            'team_id' => [
                'required',
                'integer',
                Rule::in(Teams::query()
                    ->join('users', 'users.id', 'teams.user_id')
                    ->where('users.id', user()->id)
                    ->pluck('teams.id')
                    ->toArray())
            ],
            'user_id' => [
                'required',
                'integer',
                Rule::in(User::query()
                    ->where('role', UserRoleEnum::READER)
                    ->pluck('id')
                    ->toArray())
            ],
            'languages' => [
                'required',
                'array',
                Rule::in(Language::query()
                    ->pluck('id')
                    ->toArray())
            ]
        ];
    }
}

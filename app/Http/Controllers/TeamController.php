<?php

namespace App\Http\Controllers;

use App\Enums\TeamUsersStatusEnum;
use App\Enums\UserRoleEnum;
use App\Http\Requests\TeamUsers\StoreRequest;
use App\Models\Language;
use App\Models\Teams;
use App\Models\TeamUsers;
use App\Models\User;
use App\Models\UserLanguage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TeamController extends Controller
{
    use ResponseTrait;

    public function show(Request $request, $id)
    {
        try {
            $team = Teams::query()
                ->where('teams.id', '=', (string)$id);


            $data = User::query()
                ->with('languages')
                ->selectRaw('SUM(chapters.view) as sum_view ,COUNT(DISTINCT comic_id) as sum_comic')
                ->addSelect([
                    'users.id',
                    'users.avatar',
                    'users.name',
                    'users.nickname',
                    'users.email',
                    'users.phone',
                    'users.location',
                    'users.description',
                    'users.gender',
                ])
                ->addSelect([
                    'team_users.created_at as join_at',
                    'team_users.status as status',
                ])
                ->join('team_users', 'users.id', '=', 'team_users.user_id')
                ->leftJoin('comics', 'comics.user_id', '=', 'users.id')
                ->leftJoin('chapters', 'chapters.comic_id', '=', 'comics.id')
                ->joinSub($team, 'team', function ($join) {
                    return $join->on('team.id', '=', 'team_users.team_id');
                })
                ->where(function ($query) {
                    if (request()->has('q')) {
                        return $query->where('users.name', 'like', '%' . request()->q . '%');
                    }
                    return $query;
                });

            if ($request->has('languages')) {
                $languages = $request->get('languages');

                $userIds = Language::query()
                    ->select('user_languages.user_id')
                    ->join('user_languages', 'user_languages.language_id', '=', 'languages.id')
                    ->groupBy('user_languages.user_id')
                    ->whereIn('user_languages.language_id', $languages)
                    ->having(DB::raw('count(user_languages.language_id)'), '=', count($languages));

                $data->whereIn('users.id', $userIds);
            }

            if ($request->has('status')) {
                $data->where('team_users.status', '=', $request->get('status'));
            }

            if ($request->has('q')) {
                $data->where(function ($query) use ($request) {
                    $query->where('users.name', 'like', '%' . $request->get('q') . '%')
                        ->orWhere('users.nickname', 'like', '%' . $request->get('q') . '%')
                        ->orWhere('users.phone', 'like', '%' . $request->get('q') . '%')
                        ->orWhere('users.email', 'like', '%' . $request->get('q') . '%');
                });
            }

            $data = $data->groupBy('users.id', 'status', 'join_at')
                ->paginate();

            foreach ($data as $each) {
                $each->gender = getGenderName($each->gender);
                $each['status_name'] = Str::title(TeamUsersStatusEnum::getKey($each->status));
            }

            return $this->successResponse($data);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function storeTranslator(StoreRequest $request)
    {
        try {
            $data = $request->validated();

            TeamUsers::query()->create([
                'team_id' => $data["team_id"],
                'user_id' => $data['user_id'],
                'status' => TeamUsersStatusEnum::PENDING,
            ]);

            foreach ($data['languages'] as $language) {
                UserLanguage::query()->create([
                    'user_id' => $data['user_id'],
                    'language_id' => $language
                ]);
            }

            return $this->successResponse();
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Enums\UserRoleEnum;
use App\Http\Requests\TeamUsers\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\Chapter;
use App\Models\Comic;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    use ResponseTrait;

    private $model;
    function __construct()
    {
        $this->model = new User();
    }

    public function index()
    {
        try {
            $translators = $this->model->query()
                ->select('users.id', 'team_users.user_id', 'users.name', 'users.nickname')
                ->leftJoin('team_users', 'team_users.user_id', 'users.id')
                ->where('role', '=', UserRoleEnum::READER)
                ->whereNull('team_users.user_id')
                ->where(function ($query) {
                    return $query
                        ->where('users.name', 'like', '%' . request()->get('q') . '%')
                        ->orWhere('users.nickname', 'like', '%' . request()->get('q') . '%');
                })
                ->paginate(8);

            return $this->successResponse($translators);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function getTranslators()
    {
        try {
            $translators = $this->model->query()
                ->select('users.id', 'users.name', 'users.nickname')
                ->join('team_users', 'team_users.user_id', '=', 'users.id')
                ->join('teams', 'teams.id', '=', 'team_users.team_id')
                ->where('role', '=', UserRoleEnum::TRANSLATOR)
                ->where('teams.user_id', '=', user()->id)
                ->where(function ($query) {
                    return $query
                        ->where('users.name', 'like', '%' . request()->get('q') . '%')
                        ->orWhere('users.nickname', 'like', '%' . request()->get('q') . '%');
                })
                ->get();

            return $this->successResponse($translators);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function isTranslator()
    {
        try {
            $user = $this->model->query()->findOrFail(user()->id);

            if ($user->role === UserRoleEnum::TRANSLATOR) {
                return $this->successResponse(true);
            }
            return $this->successResponse(false);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function update(UpdateRequest $request, $id)
    {
        try {
            $data = $request->validated();

            $user = User::query()
                ->where('id', '=', $id)
                ->firstOrFail();

            $user['name'] = $data['name'];
            $user['nickname'] = $data['nickname'];
            $user['gender'] = $data['gender'];
            $user['location'] = $data['location'];
            $user['description'] = $data['description'];
            $user->save();

            dd($user);

            return $this->successResponse([], 'Your profile has been updated successfully');
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function updateAvatar(Request $request, $id)
    {
        try {
            $user = User::query()
                ->where('id', '=', $id)
                ->firstOrFail();

            $path = Storage::disk('public')->put("user_images/user_$user->id", $request->file('avatar'));
            $user['avatar'] = 'storage/' . $path;
            $user->save();

            return $this->successResponse($user['avatar'], 'Your avatar has been updated successfully');
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function signUpNotification(Request $request)
    {
        try {
            $email = $request->get('email');
            if (!trim($email)) return $this->errorResponse('Email is empty!');

            event(new VerifyEmail());
            return $this->successResponse();
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function getTranslatorsForRanking()
    {
        try {
            $pre_view = $this->model->query()
                ->addSelect([
                    'users.id',
                    DB::raw('SUM(chapters.view) as view')
                ])
                ->where(DB::raw('MONTH(chapters.created_at)'), '>=', Carbon::now()->month - 2)
                ->join('comics', 'comics.user_id', 'users.id')
                ->join('chapters', 'chapters.comic_id', 'comics.id')
                ->groupBy('users.id');

            $cur_chapter = Chapter::query()
                ->addSelect([
                    'user_id',
                    DB::raw('count(chapters.id) as cur_chapter')
                ])
                ->join('comics', 'comics.id', 'chapters.comic_id')
                ->where(DB::raw('MONTH(chapters.created_at)'), Carbon::now()->month)
                ->groupBy('user_id');

            $pre_chapter = Chapter::query()
                ->addSelect([
                    'user_id',
                    DB::raw('count(chapters.id) as pre_chapter')
                ])
                ->join('comics', 'comics.id', 'chapters.comic_id')
                ->where(DB::raw('MONTH(chapters.created_at)'), Carbon::now()->month - 1)
                ->groupBy('user_id');

            $cur_rate = $this->model::query()
                ->addSelect([
                    'users.id as user_id',
                    DB::raw('ROUND(AVG(ratings.rate), 2) as cur_rate')
                ])
                ->leftJoin('comics', 'comics.user_id', 'users.id')
                ->leftJoin('ratings', 'ratings.comic_id', 'comics.id')
                ->where(function ($query) {
                    $query->where('users.role', UserRoleEnum::TRANSLATOR)
                        ->where(DB::raw('MONTH(ratings.created_at)'), Carbon::now()->month);
                })
                ->groupBy('users.id');

            $data = $this->model->query()
                ->addSelect([
                    'users.avatar',
                    'users.name',
                    'users.nickname',
                    'teams.name as team_name',
                    'pre_view.view',
                    'cur_chapter.cur_chapter',
                    'pre_chapter.pre_chapter',
                    'cur_rate.cur_rate'
                ])
                ->join('team_users', 'team_users.user_id', 'users.id')
                ->join('teams', 'teams.id', 'team_users.team_id')
                ->leftJoinSub($pre_view, 'pre_view', function ($join) {
                    $join->on('pre_view.id', '=', 'users.id');
                })
                ->leftJoinSub($cur_chapter, 'cur_chapter', function ($join) {
                    $join->on('cur_chapter.user_id', '=', 'users.id');
                })
                ->leftJoinSub($pre_chapter, 'pre_chapter', function ($join) {
                    $join->on('pre_chapter.user_id', '=', 'users.id');
                })
                ->leftJoinSub($cur_rate, 'cur_rate', function ($join) {
                    $join->on('cur_rate.user_id', '=', 'users.id');
                })
                ->where('role', UserRoleEnum::TRANSLATOR)
                ->get();

            return $this->successResponse($data);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Models\Teams;
use App\Models\TeamUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Enums\TeamStatusEnum;
use App\Enums\TeamUsersStatusEnum;
use Illuminate\Support\Str;

class TeamController extends AdminController
{
    private $model;
    public function __construct()
    {
        $this->model = new Teams();
        $currentRoute = "teams";

        $arrStatus = TeamUsersStatusEnum::asArray();

        view()->share([
            'currentRoute' => $currentRoute,
            'table' => "admin." . $this->model->getTable(),
            'arrStatus' => $arrStatus,
        ]);
    }

    public function index(Request $request)
    {
        if (isSuperAdmin()) {
            $subTable = Teams::query()
                ->addSelect([
                    'teams.*',
                    DB::raw('COUNT(comics.user_id) as count_comic'),
                ])
                ->join('team_users', 'team_users.team_id', '=', 'teams.id')
                ->join('comics', 'comics.user_id', '=', 'team_users.user_id')
                ->groupBy('teams.id');

            $data = TeamUsers::query()
                ->addSelect([
                    'subTable.*',
                    DB::raw('COUNT(team_users.user_id) as count_member'),
                    'users.name as user_name',
                    'users.nickname as user_nickname',
                ])
                ->joinSub($subTable, 'subTable', function ($join) {
                    $join->on('subTable.id', '=', 'team_users.team_id');
                })
                ->join('users', 'users.id', '=', 'subTable.user_id')
                ->where(function ($query) use ($request) {
                    if ($request->q) {
                        $query->where('subTable.name', 'like', "%{$request->q}%");
                    }
                    return $query;
                })
                ->groupBy('subTable.id')
                ->paginate();

            foreach ($data as $each) {
                $each['status_name'] = Str::title(TeamStatusEnum::getKey($each->status));
            }
        } else if (isAdmin()) {
            $data = $this->model->query()
                ->select('teams.id')
                ->join('users', 'users.id', '=', 'teams.user_id')
                ->first();
        }

        return view('clients.admin.team.index', [
            'data' => $data,
        ]);
    }

    public function show(Request $request, $id)
    {
        $subTable = Teams::query()
            ->addSelect([
                'teams.*',
                DB::raw('COUNT(comics.user_id) as count_comic'),
                DB::raw('ROUND(AVG(rate), 2) as rate')
            ])
            ->join('team_users', 'team_users.team_id', '=', 'teams.id')
            ->join('comics', 'comics.user_id', '=', 'team_users.user_id')
            ->leftJoin('ratings', 'ratings.comic_id', '=', 'comics.id')
            ->groupBy('teams.id');

        $data = TeamUsers::query()
            ->addSelect([
                'subTable.*',
                DB::raw('COUNT(team_users.user_id) as count_member'),
                'users.name as user_name',
                'users.nickname as user_nickname',
            ])
            ->joinSub($subTable, 'subTable', function ($join) {
                $join->on('subTable.id', '=', 'team_users.team_id');
            })
            ->join('users', 'users.id', '=', 'subTable.user_id')
            ->where(function ($query) use ($request, $id) {
                if ($request->q) {
                    $query->where('subTable.name', 'like', "%{$request->q}%");
                }
                return $query->where('subTable.id', $id);
            })
            ->groupBy('subTable.id')
            ->first();

        return view('clients.admin.team.show', [
            'data' => $data,
        ]);
    }

    public function destroy($id)
    {
        # code...
    }
}

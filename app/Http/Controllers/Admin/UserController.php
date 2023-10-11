<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRoleEnum;
use App\Http\Controllers\AdminController;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends AdminController
{
    private $model;
    public function __construct()
    {
        $this->model = new User();
        $currentRoute = 'users';

        view()->share([
            'currentRoute' => $currentRoute,
            'table' => "admin." . $this->model->getTable(),
        ]);
    }
    public function index(Request $request)
    {
        $users = $this->model->query();

        if ($request->has('q')) {
            $users = $users
                ->where(function ($query) use ($request) {
                    return $query->where('name', 'like', '%' . $request->get('q') . '%')
                        ->orWhere('nickname', 'like', '%' . $request->get('q') . '%')
                        ->orWhere('phone', 'like', '%' . $request->get('q') . '%')
                        ->orWhere('email', 'like', '%' . $request->get('q') . '%');
                });
        }

        $roleSeleted = $request->get('role');
        if ($roleSeleted !== '-1' && $roleSeleted !== NULL) {
            $users = $users->where('role', $roleSeleted);
        }

        $users = $users->select([
            'id',
            'email',
            'avatar',
            'name',
            'nickname',
            'role',
            'phone',
            'location',
            'description',
            'gender',
            'created_at'
        ])->paginate();

        foreach ($users as $user) {
            $user->role = $user->role_name;
            $user->gender = $user->gender_name;
        }

        $roles = titleArray(UserRoleEnum::getKeys(), '_', ' ');

        return view('clients.admin.user.index', [
            'users' => $users,
            'roles' => $roles,
            'roleSeleted' => $roleSeleted,
        ]);
    }

    public function show($id)
    {
    }

    public function destroy($id)
    {
        $user = $this->model->query()->find($id);

        if ($user) {
            $user->delete();
        }

        return redirect()->back();
    }
}

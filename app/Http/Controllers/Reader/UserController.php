<?php

namespace App\Http\Controllers\Reader;

use App\Enums\ComicStatusEnum;
use App\Enums\UserGenderEnum;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    private $model;
    public function __construct()
    {
        $this->model = new User();
        $arrGenre = Category::query()
            ->select([
                'categories.id',
                'categories.name',
                'categories.slug',
            ])
            ->join('comic_categories', 'comic_categories.category_id', '=', 'categories.id')
            ->join('comics', 'comics.id', '=', 'comic_categories.comic_id')
            ->where('comics.status', '!=', ComicStatusEnum::PENDING)
            ->groupBy('categories.id')
            ->get();

        view()->share([
            'arrGenre' => $arrGenre,
        ]);
    }

    public function show($id)
    {
        $user = $this->model->query()
            ->addSelect('users.*')
            ->addSelect([
                DB::raw('COUNT(histories.id) as comicCount')
            ])
            ->leftJoin('histories', 'histories.user_id', '=', 'users.id')
            ->where('users.id', $id)
            ->groupBy('users.id')
            ->first();

        return view('clients.reader.user.show', [
            'user' => $user,
        ]);
    }

    public function edit($id)
    {
        $user = $this->model->query()
            ->addSelect('users.*')
            ->addSelect([
                DB::raw('COUNT(histories.id) as comicCount')
            ])
            ->leftJoin('histories', 'histories.user_id', '=', 'users.id')
            ->where('users.id', $id)
            ->groupBy('users.id')
            ->first();

        $arrGender = UserGenderEnum::ArrayView();

        return view('clients.reader.user.edit', [
            'user' => $user,
            'arrGender' => $arrGender,
        ]);
    }
}

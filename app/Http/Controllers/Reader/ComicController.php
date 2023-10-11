<?php

namespace App\Http\Controllers\Reader;

use App\Enums\ChapterStatusEnum;
use App\Enums\ComicStatusEnum;
use App\Enums\UserRoleEnum;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Chapter;
use App\Models\Comic;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComicController extends Controller
{
    private $model;
    public function __construct()
    {
        $this->model = new Comic();

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

        view()->share('arrGenre', $arrGenre);
    }

    public function index($slug)
    {
        $data = $this->model->query()
            ->addSelect([
                'comics.*'
            ])
            ->addSelect([
                DB::raw('ROUND(AVG(ratings.rate), 1) as rate'),
                DB::raw('COUNT(ratings.rate) as rate_count')
            ])
            ->when(user(), function ($query) {
                return $query->selectSub(
                    "Select id from libraries
                        Where comic_id = comics.id
                        and user_id = " . user()->id,
                    'addedLibraries'
                );
            })
            ->with('user')
            ->with('categories')
            ->with('chapters', function ($query) {
                return $query->where('status', ChapterStatusEnum::APPROVED)
                    ->orderBy('number', 'asc');
            })
            ->leftJoin('ratings', 'ratings.comic_id', '=', 'comics.id')
            ->where('slug', '=', $slug)
            ->where('status', '!=', ComicStatusEnum::PENDING)
            ->groupBy('comics.id')
            ->firstOrFail();

        $chapters = $this->model->query()
            ->addSelect([
                'chapters.*'
            ])
            ->join('chapters', 'chapters.comic_id', '=', 'comics.id')
            ->where('comics.slug', '=', $slug)
            ->where('chapters.status', '=', ChapterStatusEnum::APPROVED)
            ->orderBy('chapters.number', 'desc')
            ->get();

        $randomComics = Comic::query()
            ->addSelect([
                'comics.id',
                'comics.name',
                'comics.alias',
                'comics.avatar',
                'comics.description',
                'comics.slug',
            ])
            ->addSelect([
                'categories.name as category_name',
                'categories.slug as category_slug',
            ])
            ->addSelect([
                DB::raw('ROUND(AVG(ratings.rate), 1) as rate'),
            ])
            ->join('comic_categories', 'comic_categories.comic_id', '=', 'comics.id')
            ->join('categories', 'categories.id', '=', 'comic_categories.category_id')
            ->leftJoin('ratings', 'ratings.comic_id', '=', 'comics.id')
            ->where('comics.status', '!=', ComicStatusEnum::PENDING)
            ->where('categories.id', '=', $data->categories[0]->id)
            ->where('comics.id', '!=', $data->id)
            ->groupBy('comics.id', 'categories.id')
            ->inRandomOrder()
            ->limit(6)
            ->get();

        return view('clients.reader.comic.index', [
            'data' => $data,
            'randomComics' => $randomComics,
            'chapters' => $chapters,
        ]);
    }
}

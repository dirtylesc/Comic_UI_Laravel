<?php

namespace App\Http\Controllers\Reader;

use App\Enums\BrowseSortEnum;
use App\Enums\ChapterStatusEnum;
use App\Enums\ComicStatusEnum;
use App\Enums\FilesStatusEnum;
use App\Enums\FilesTypeEnum;
use App\Enums\RankNameRankingEnum;
use App\Enums\TimeTypeRankingEnum;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseTrait;
use App\Models\Category;
use App\Models\Chapter;
use App\Models\Comic;
use App\Models\ComicCategories;
use App\Models\File;
use App\Models\History;
use App\Models\Library;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    use ResponseTrait;

    public function __construct()
    {
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

    public function index()
    {
        $weeklyComics = File::query()
            ->where('type', '=', FilesTypeEnum::WEEKLY_COMIC)
            ->where('status', '=', FilesStatusEnum::APPROVED)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        $banner = File::query()
            ->where('type', '=', FilesTypeEnum::BANNER)
            ->where('status', '=', FilesStatusEnum::APPROVED)
            ->first();

        $featuredComics = Comic::query()
            ->with('categories')
            ->where('status', '!=', ComicStatusEnum::PENDING)
            ->inRandomOrder()
            ->limit(13)
            ->get();

        $specialComic = Comic::query()
            ->selectSub("
                Select chapters.slug as chapter_slug from chapters
                where chapters.comic_id = comics.id
                and chapters.status = " . ChapterStatusEnum::APPROVED . "
                order by chapters.created_at asc
                limit 1
            ", 'chapter_slug')
            ->addSelect([
                'comics.id',
                'comics.name',
                'comics.alias',
                'comics.avatar',
                'comics.description',
                'comics.slug',
            ])
            ->addSelect([
                DB::raw('ROUND(AVG(ratings.rate), 1) as rate')
            ])
            ->with('categories')
            ->join('chapters', 'chapters.comic_id', '=', 'comics.id')
            ->join('ratings', 'ratings.comic_id', '=', 'comics.id')
            ->where('comics.status', '!=', ComicStatusEnum::PENDING)
            ->groupBy('comics.id')
            ->orderBy('rate', 'desc')
            ->first();

        $powerRankingComics = Comic::query()
            ->addSelect([
                'comics.id',
                'name',
                'alias',
                'avatar',
                'description',
                'slug',
            ])
            ->addSelect([
                DB::raw('ROUND(AVG(ratings.rate), 1) as rate')
            ])
            ->with('categories')
            ->leftJoin('ratings', 'ratings.comic_id', '=', 'comics.id')
            ->where('comics.status', '!=', ComicStatusEnum::PENDING)
            ->groupBy('comics.id')
            ->orderBy('rate', 'desc')
            ->limit(10)
            ->get();

        $newComics = Comic::query()
            ->addSelect([
                'comics.id',
                'name',
                'alias',
                'avatar',
                'description',
                'slug',
            ])
            ->addSelect([
                DB::raw('ROUND(AVG(ratings.rate), 1) as rate')
            ])
            ->with('categories')
            ->leftJoin('ratings', 'ratings.comic_id', '=', 'comics.id')
            ->where('comics.status', '!=', ComicStatusEnum::PENDING)
            ->groupBy('comics.id')
            ->orderBy('comics.created_at', 'desc')
            ->limit(10)
            ->get();

        $collectionRankingComics = Comic::query()
            ->selectRaw('Sum(chapters.view) as total_views')
            ->addSelect([
                'comics.id',
                'name',
                'alias',
                'avatar',
                'description',
                'comics.slug',
            ])
            ->addSelect([
                DB::raw('ROUND(AVG(ratings.rate), 1) as rate')
            ])
            ->with('categories')
            ->join('chapters', 'chapters.comic_id', 'comics.id')
            ->leftJoin('ratings', 'ratings.comic_id', '=', 'comics.id')
            ->where('comics.status', '!=', ComicStatusEnum::PENDING)
            ->groupBy('comics.id')
            ->orderBy('total_views', 'desc')
            ->limit(10)
            ->get();

        $compeletedComics = Comic::query()
            ->addSelect([
                'comics.id',
                'name',
                'alias',
                'avatar',
                'description',
                'slug',
            ])
            ->with('categories')
            ->where('comics.status', '=', ComicStatusEnum::COMPLETED)
            ->groupBy('comics.id')
            ->inRandomOrder()
            ->limit(8)
            ->get();

        $risingFictions = Comic::query()
            ->selectSub("
                Select chapters.slug as chapter_slug from chapters
                where chapters.comic_id = comics.id
                and chapters.status = " . ChapterStatusEnum::APPROVED . "
                order by chapters.created_at asc
                limit 1
            ", 'chapter_slug')
            ->addSelect([
                'comics.id',
                'comics.name',
                'comics.alias',
                'comics.avatar',
                'comics.description',
                'comics.slug',
            ])
            ->addSelect([
                DB::raw('ROUND(AVG(ratings.rate), 1) as rate')
            ])
            ->with('categories')
            ->join('chapters', 'chapters.comic_id', '=', 'comics.id')
            ->leftJoin('ratings', 'ratings.comic_id', '=', 'comics.id')
            ->where('comics.status', '!=', ComicStatusEnum::PENDING)
            ->groupBy('comics.id')
            ->inRandomOrder()
            ->limit(9)
            ->get();

        $cherringReads = Comic::query()
            ->addSelect([
                'comics.id',
                'name',
                'alias',
                'avatar',
                'description',
                'slug',
            ])
            ->with('categories')
            ->where('comics.status', '=', ComicStatusEnum::COMPLETED)
            ->groupBy('comics.id')
            ->inRandomOrder()
            ->limit(6)
            ->get();

        $popularTags = ComicCategories::query()
            ->selectRaw('count(comic_categories.category_id) as count_categories')
            ->addSelect([
                'categories.id',
                'categories.name',
                'categories.slug'
            ])
            ->join('categories', 'categories.id', '=', 'comic_categories.category_id')
            ->groupBy('categories.id')
            ->orderBy('count_categories', 'desc')
            ->limit(11)
            ->get();

        return view('clients.reader.index', [
            'weeklyComics' => $weeklyComics,
            'featuredComics' => $featuredComics,
            'banner' => $banner,
            'specialComic' => $specialComic,
            'powerRankingComics' => $powerRankingComics,
            'newComics' => $newComics,
            'collectionRankingComics' => $collectionRankingComics,
            'compeletedComics' => $compeletedComics,
            'risingFictions' => $risingFictions,
            'cherringReads' => $cherringReads,
            'popularTags' => $popularTags,
        ]);
    }

    public function stories(Request $request)
    {

        $arrSort = BrowseSortEnum::ArrayView();
        $arrStatus = ComicStatusEnum::ArrayViewBrowse();
        $arrRankName = RankNameRankingEnum::asArray();
        $arrTimeType = TimeTypeRankingEnum::ArrayView();

        return view('clients.reader.browse', [
            'arrSort' => $arrSort,
            'arrStatus' => $arrStatus,
            'arrRankName' => $arrRankName,
            'arrTimeType' => $arrTimeType,
            'search' => $request->get('search'),
        ]);
    }

    public function ranking()
    {
        $arrRankName = RankNameRankingEnum::asArray();
        $arrTimeType = TimeTypeRankingEnum::ArrayView();

        return view('clients.reader.ranking', [
            'arrRankName' => $arrRankName,
            'arrTimeType' => $arrTimeType,
        ]);
    }
}

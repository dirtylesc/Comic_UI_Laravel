<?php

namespace App\Http\Controllers\Reader;

use App\Enums\ChapterStatusEnum;
use App\Enums\ComicStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\History;
use App\Models\Library;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistoryController extends Controller
{
    public function index()
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

        $data = History::query()
            ->addSelect([
                DB::raw('comics.id as comicId'),
                'comics.avatar',
                'comics.name',
                'comics.alias',
                DB::raw('comics.slug as comicSlug'),
                'comics.description',
            ])
            ->addSelect([
                DB::raw('chapters.id as chapterId'),
                DB::raw('chapters.slug as chapterSlug'),
                DB::raw('chapters.number as chapterNumber'),
            ])
            ->addSelect([
                DB::raw('ROUND(AVG(ratings.rate), 1) as rate'),
            ])
            ->selectSub(
                "Select chapter_id from libraries
                Where chapter_id = chapterId
                and user_id = " . user()->id . "
                ",
                'addedLibraries'
            )
            ->selectSub(
                "Select number from chapters
                where comic_id = comics.id
                and status = " . ChapterStatusEnum::APPROVED . "
                order by number desc
                limit 1
                ",
                'chapterTotal'
            )
            ->selectSub(
                "Select name from categories
                join comic_categories on comic_categories.category_id = categories.id
                where comic_categories.comic_id = comicId
                limit 1",
                'category'
            )
            ->join('chapters', 'chapters.id', '=', 'histories.chapter_id')
            ->join('comics', 'comics.id', '=', 'chapters.comic_id')
            ->leftJoin('ratings', 'ratings.comic_id', '=', 'comics.id')
            ->where(function ($query) {
                $query->where('histories.user_id', '=', user()->id);
            })
            ->groupBy('histories.id')
            ->orderBy('histories.updated_at', 'desc')
            ->get();

        return view('clients.reader.history', [
            'data' => $data,
            'arrGenre' => $arrGenre,
        ]);
    }

    public function addToHistory(Request $request)
    {
        $comicId = $request->get('comicId');
        $chapterId = $request->get('chapterId');
        $userId = user()->id;

        $history = History::query()
            ->select('histories.*')
            ->join('chapters', 'chapters.id', '=', 'histories.chapter_id')
            ->where('chapters.comic_id', '=', $comicId)
            ->where('user_id', '=', $userId)
            ->first();

        if ($history) {
            $history->chapter_id = $chapterId;
            $history->save();
        } else {
            $history = new History();
            $history->chapter_id = $chapterId;
            $history->user_id = $userId;
            $history->save();
        }

        $library = Library::query()
            ->where('comic_id', '=', $comicId)
            ->where('user_id', '=', $userId)
            ->first();

        if ($library) {
            $library->chapter_id = $chapterId;
            $library->save();
        }
    }
}

<?php

namespace App\Http\Controllers\Reader;

use App\Enums\BrowseSortEnum;
use App\Enums\ChapterStatusEnum;
use App\Enums\ComicStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseTrait as ControllersResponseTrait;
use App\Models\Category;
use App\Models\History;
use App\Models\Library;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LibraryController extends Controller
{
    use ControllersResponseTrait;

    public function library()
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

        $data = Library::query()
            ->addSelect([
                DB::raw('comics.id as comicId'),
                'comics.avatar',
                'comics.name',
                DB::raw('comics.slug as comicSlug')
            ])
            ->selectSub(
                "Select number from chapters
                where comic_id = comicId
                and status = " . ChapterStatusEnum::APPROVED . "
                order by number desc
                limit 1
                ",
                'chapterTotal'
            )
            ->addSelect([
                DB::raw('
                    if(chapters.slug IS NULL, (
                    SELECT chapters.slug from chapters
                    join comics on comics.id = chapters.comic_id
                    WHERE chapters.`status` = 1
                    and comics.id = comicId
                    ORDER BY chapters.id ASC
                    LIMIT 1
                ), chapters.slug) as chapterSlug'),
                DB::raw('chapters.number as chapterNumber')
            ])
            ->leftJoin('chapters', 'chapters.id', '=', 'libraries.chapter_id')
            ->leftJoin('comics', 'comics.id', '=', 'libraries.comic_id')
            ->where('libraries.user_id', '=', user()->id)
            ->paginate(18);

        return view('clients.reader.library', [
            'data' => $data,
            'arrGenre' => $arrGenre,
        ]);
    }

    public function addToLibrary(Request $request)
    {
        $library = Library::query()
            ->where('user_id', '=', user()->id)
            ->where('comic_id', '=', $request->comicId)
            ->first();

        if ($library) {
            return $this->errorResponse('Đã có trong thư viện');
        }

        $history = History::query()
            ->join('chapters', 'chapters.id', '=', 'histories.chapter_id')
            ->where('histories.user_id', '=', user()->id)
            ->where('chapters.comic_id', '=', $request->comicId)
            ->first();

        $library = new Library();
        $library->user_id = user()->id;
        $library->comic_id = $request->comicId;

        if ($history) {
            $library->chapter_id = $history->chapter_id;
        }
        $library->save();

        return $this->successResponse('Thêm vào thư viện thành công');
    }

    public function removeFromLibrary(Request $request)
    {
        $library = Library::query()
            ->where('user_id', '=', user()->id)
            ->where('comic_id', '=', $request->comicId)
            ->first();

        if (!$library) {
            return $this->errorResponse('Không có trong thư viện');
        };

        $library->delete();

        return $this->successResponse('Đã xóa khỏi thư viện thành công');
    }
}

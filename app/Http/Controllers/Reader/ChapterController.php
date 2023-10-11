<?php

namespace App\Http\Controllers\Reader;

use App\Enums\ChapterStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Comic;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = new Chapter();
    }

    public function index($slug, $chapterSlug)
    {
        $data = Comic::query()
            ->with('chapter', function ($query) use ($chapterSlug) {
                return $query
                    ->where('slug', $chapterSlug)
                    ->where('status', '=', ChapterStatusEnum::APPROVED)
                    ->firstOrFail();
            })
            ->where('slug', $slug)
            ->firstOrFail();

        $chapters = Chapter::query()
            ->addSelect('chapters.id', 'chapters.number', 'chapters.title', 'chapters.slug')
            ->join('comics', 'comics.id', '=', 'chapters.comic_id')
            ->where('comics.slug', $slug)
            ->where('chapters.status', '=', ChapterStatusEnum::APPROVED)
            ->orderBy('chapters.number', 'asc')
            ->get();

        $chapter = $this->model->query()
            ->where(function ($query) use ($data, $chapterSlug) {
                $query->where('comic_id', $data->id)
                    ->where('slug', $chapterSlug);
            })
            ->first();

        $chapter->view += 1;
        $chapter->save();

        return view('clients.reader.comic.show_chapter', [
            'data' => $data,
            'chapters' => $chapters,
        ]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ChapterStatusEnum;
use App\Http\Controllers\AdminController;
use App\Models\Chapter;
use App\Models\Comic;
use Illuminate\Http\Request;

class ChapterController extends AdminController
{
    private $model;
    function __construct()
    {
        $this->model = new Chapter();
        $currentRoute = 'comics';

        view()->share([
            'currentRoute' => $currentRoute,
        ]);
    }

    public function index($slug)
    {
        $arrStatus = ChapterStatusEnum::getKeys();

        $arrStatus = titleArray($arrStatus);

        $lastestChapter = Chapter::query()
            ->orderBy('number', 'desc')
            ->value('number');

        $comic = Comic::query()
            ->with('categories')
            ->whereSlug($slug)
            ->firstOrFail();

        return view('clients.admin.chapter.index', [
            'arrStatus' => $arrStatus,
            'comic' => $comic,
            'lastestChapter' => $lastestChapter,
        ]);
    }

    public function previewChapter(Request $request)
    {
        $images = $request->images;
        dd($images);
    }
}

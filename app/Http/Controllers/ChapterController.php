<?php

namespace App\Http\Controllers;

use App\Enums\ChapterStatusEnum;
use App\Http\Requests\Chapter\CheckSlugRequest;
use App\Http\Requests\Chapter\StoreRequest;
use App\Http\Requests\Chapter\UpdateRequest;
use App\Models\Chapter;
use App\Models\ChapterImages;
use App\Models\Comic;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ChapterController extends Controller
{
    use ResponseTrait;

    private $model;
    public function __construct()
    {
        $this->model = new Chapter();
    }

    public function index(Request $request, $id)
    {
        try {
            $chapters = $this->model->query()
                ->where(function ($query) use ($id, $request) {
                    $query->where('comic_id', $id);
                    if (request()->status !== '-1') {
                        $query->whereStatus(request()->status);
                    }

                    $query->whereRaw("(
                        title like '%{$request->q}%' 
                        or number like '{$request->q}%'
                        or chapters.created_at >= '{$request->q}%')");

                    return $query;
                })
                ->orderBy('chapters.status', 'asc')
                ->orderBy('chapters.id', 'desc')
                ->paginate();


            foreach ($chapters as $chapter) {
                $chapter->status = $chapter->status_name;
                $chapter->created_at = parseTimezone($chapter->created_at);
            }

            return $this->successResponse($chapters);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function getImages($id)
    {
        try {
            $images = ChapterImages::query()->where('chapter_id', '=', $id)->get()->toArray();

            return $this->successResponse($images);
        } catch (\Throwable $th) {
            return $this->errorResponse('Chapter not found');
        }
    }

    public function approveStatus($chapter_id)
    {
        try {
            $chapter = $this->model->query()
                ->where('status', '=', ChapterStatusEnum::PENDING)
                ->findOrFail($chapter_id);

            $chapter->status = ChapterStatusEnum::APPROVED;
            $chapter->save();

            //Update comic last update
            Comic::query()->where('id', '=', $chapter->comic_id)
                ->update([
                    'updated_at' => Carbon::now()
                ]);

            return $this->successResponse([], "Chapter $chapter->number has been approved");
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function checkSlug($id, CheckSlugRequest $request)
    {
        return $this->successResponse([], 'Slug is available');
    }

    public function store(StoreRequest $request)
    {
        try {
            $data = $request->validated();

            $data['status'] = ChapterStatusEnum::PENDING;
            $chapter = $this->model->query()->create($data);

            $slugComic = $data['comic_slug'];
            foreach ($data['images'] as $image) {
                $slugChapter = $data['slug'];
                $path = Storage::disk('public')->put("comic_images/$slugComic/$slugChapter", $image);

                ChapterImages::query()->create([
                    'chapter_id' => $chapter->id,
                    'link' => $path,
                ]);
            }

            return $this->successResponse([], 'Chapter has been created');
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function update(UpdateRequest $request, $id)
    {
        try {
            $data = $request->validated();

            $chapter = $this->model->query()->findOrFail($id);

            $chapter->title = $data['title'];
            $chapter->slug = $data['slug'];
            $chapter->number = $data['number'];
            $chapter->comic_id = $data['comic_id'];
            $chapter->status = ChapterStatusEnum::PENDING;
            $chapter->updated_at = Carbon::now();

            if ($request->images) {
                $slugComic = $data['comic_slug'];
                $slugChapter = $data['slug'];

                //Delete old images
                Storage::disk('public')
                    ->deleteDirectory("comic_images/$slugComic/$slugChapter");

                //Delete old images of chapter in database
                ChapterImages::query()
                    ->where('chapter_id', '=', $chapter->id)
                    ->delete();

                //Save new images of chapter in database
                foreach ($data['images'] as $image) {
                    $path = Storage::disk('public')->put("comic_images/$slugComic/$slugChapter", $image);

                    ChapterImages::query()->create([
                        'chapter_id' => $chapter->id,
                        'link' => $path,
                    ]);
                }
            }
            $chapter->save();

            //Update comic last update
            Comic::query()->where('slug', '=', $data['comic_slug'])
                ->update([
                    'updated_at' => Carbon::now()
                ]);

            return $this->successResponse([], 'Chapter has been created');
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $chapter = $this->model->query()->findOrFail($id);

            $slugComic = $request->comic_slug;
            $slugChapter = $chapter->slug;

            //Delete old images
            Storage::disk('public')
                ->deleteDirectory("comic_images/$slugComic/$slugChapter");

            //Delete old images of chapter in database
            ChapterImages::query()
                ->where('chapter_id', '=', $chapter->id)
                ->delete();

            $chapter->delete();

            return $this->successResponse([], 'Chapter has been deleted');
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }
}

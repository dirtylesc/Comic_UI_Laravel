<?php

namespace App\Http\Controllers;

use App\Enums\BrowseSortEnum;
use App\Enums\ChapterStatusEnum;
use App\Enums\ComicStatusEnum;
use App\Enums\TimeTypeRankingEnum;
use App\Http\Requests\Comic\CheckSlugRequest;
use App\Http\Requests\Comic\GenerateSlugRequest;
use App\Http\Requests\Comic\GetComicForStoriesRequest;
use App\Http\Requests\Comic\StoreRequest;
use App\Http\Requests\Comic\UpdateRequest;
use App\Models\Category;
use App\Models\Comic;
use App\Models\ComicCategories;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ComicController extends Controller
{
    use ResponseTrait;

    private $model;
    public function __construct()
    {
        $this->model = new Comic();
    }

    public function index(Request $request)
    {
        try {
            $data = $this->model->query()
                ->with('categories')
                ->addSelect([
                    'comics.*'
                ])
                ->addSelect([
                    DB::raw("ROUND(AVG(ratings.rate), 2) as rate"),
                    DB::raw("COUNT(ratings.id) as count_rate")
                ])
                ->leftJoin('ratings', 'ratings.comic_id', 'comics.id');

            if ($request->has('categories')) {
                $categories = $request->get('categories');

                $comicIds = Category::query()
                    ->select('comic_categories.comic_id')
                    ->join('comic_categories', 'comic_categories.category_id', '=', 'categories.id')
                    ->groupBy('comic_categories.comic_id')
                    ->whereIn('comic_categories.category_id', $categories)
                    ->having(DB::raw('count(comic_categories.category_id)'), '=', count($categories));

                $data->whereIn('comics.id', $comicIds);
            }

            if ($request->has('status') && $request->get('status') !== '-1') {
                $data->where(function ($query) use ($request) {
                    $query->where('status', $request->get('status'));
                });
            }

            if ($request->has('q')) {
                $data->where(function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->get('q') . '%')
                        ->orWhere('alias', 'like', '%' . $request->get('q') . '%')
                        ->orWhere('author', 'like', '%' . $request->get('q') . '%');
                });
            }

            $data = $data
                ->groupBy('comics.id')
                ->orderBy('comics.id', 'desc')
                ->paginate(10);

            foreach ($data as $each) {
                $each['status_name'] = $each['status_name'];
                $each['language'] = $each['language_name'];
                $each->created_at = parseTimezone($each->created_at);
            };

            $arr['data'] = $data->getCollection();
            $arr['pagination'] = $data->linkCollection();

            return $this->successResponse($arr, 'Your data have been render success.');
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function checkSlug(CheckSlugRequest $request)
    {
        return $this->successResponse();
    }

    public function generateSlug(GenerateSlugRequest $request)
    {
        try {
            $name = $request->get('name');
            $alias = $request->get('alias');

            $slug = SlugService::createSlug(Comic::class, 'slug', $name);

            if (!empty($alias)) {
                $aliasSlug = SlugService::createSlug(Comic::class, 'slug', $alias);

                $slug .= "-($aliasSlug)";
            }

            return $this->successResponse(['slug' => $slug]);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function store(StoreRequest $request)
    {
        try {
            $data = $request->validated();

            if ($request->file('avatar')) {
                $path = Storage::disk('public')->put("storage/comic_images/$request->slug", $request->file('avatar'));
                $data['avatar'] = $path;
            }

            $data['pre_view'] = 0;
            $data['status'] = ComicStatusEnum::PENDING;

            $this->model->create($data);

            $comicId = $this->model
                ->select('id')
                ->where('slug', $data['slug'])
                ->first();

            if ($request->has('categories')) {
                $categories = $request->get('categories');

                foreach ($categories as $each) {
                    ComicCategories::query()->create([
                        'comic_id' => $comicId->id,
                        'category_id' => $each
                    ]);
                }
            }
            return $this->successResponse('Your comic have been created success.');
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function update($id, UpdateRequest $request)
    {
        try {
            $comic = $this->model->query()->findOrFail($id);

            $comic['user_id'] = $request->get('user_id');
            $comic['name'] = $request->get('name');
            $comic['alias'] = $request->get('alias');
            $comic['author'] = $request->get('author');
            $comic['status'] = $request->get('status');
            $comic['language'] = $request->get('language');
            $comic['description'] = $request->get('description');
            $comic['slug'] = $request->get('slug');

            if ($request->file('avatar')) {
                $path = Storage::disk('public')->put("storage/comic_images/$request->slug", $request->file('avatar'));
                $comic['avatar'] = $path;
            }
            $comic->save();

            if ($request->has('categories')) {
                $categories = $request->get('categories');

                ComicCategories::query()->where('comic_id', $id)->delete();

                foreach ($categories as $each) {
                    ComicCategories::query()->create([
                        'comic_id' => $id,
                        'category_id' => $each
                    ]);
                }
            }

            return redirect()->route('admin.comics.index')->with('success', 'Your comic have been updated success.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('errors', json_encode($th->getMessage()));
        }
    }

    public function changeStatus(Request $request, $id)
    {
        try {
            $comic = $this->model->query()->findOrFail($id);

            $comic['status'] = $request->get('status');
            $comic->save();

            return $this->successResponse("Your comic's status have been changed success.");
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function search(Request $request)
    {
        try {
            $data = $this->model->query()
                ->selectSub("
                    Select chapters.slug from chapters
                    where chapters.comic_id = comics.id
                    and chapters.status = " . ChapterStatusEnum::APPROVED . "
                    order by chapters.created_at desc
                    limit 1
                ", 'chapter_slug_0')
                ->selectSub("
                    Select chapters.number from chapters
                    where chapters.comic_id = comics.id
                    and chapters.status = " . ChapterStatusEnum::APPROVED . "
                    order by chapters.created_at desc
                    limit 1
                ", 'chapter_number_0')
                ->selectSub("
                    Select chapters.slug from chapters
                    where chapters.comic_id = comics.id
                    and chapters.status = " . ChapterStatusEnum::APPROVED . "
                    order by chapters.created_at desc
                    limit 1, 1
                ", 'chapter_slug_1')
                ->selectSub("
                    Select chapters.number from chapters
                    where chapters.comic_id = comics.id
                    and chapters.status = " . ChapterStatusEnum::APPROVED . "
                    order by chapters.created_at desc
                    limit 1, 1
                ", 'chapter_number_1')
                ->addSelect([
                    'comics.id',
                    'comics.name',
                    'comics.alias',
                    'comics.author',
                    'comics.slug',
                    'comics.avatar'
                ])
                ->join('chapters', 'chapters.comic_id', '=', 'comics.id')
                ->where(function ($query) use ($request) {
                    return $query
                        ->where('name', 'like', '%' . $request->q . '%')
                        ->orWhere('alias', 'like', '%' . $request->q . '%');
                })
                ->groupBY('comics.id')
                ->limit(10)
                ->get();

            return $this->successResponse($data);
        } catch (\Throwable $th) {
            return $this->errorResponse("Data search can't render.");
        }
    }

    public function getComicForStories(GetComicForStoriesRequest $request)
    {
        try {
            $data = Comic::query()
                ->with('categories')
                ->addSelect([
                    'comics.id',
                    'comics.name',
                    'comics.alias',
                    'comics.author',
                    'comics.slug',
                    'comics.description',
                    'comics.avatar'
                ])
                ->addSelect([
                    DB::raw("ROUND(AVG(ratings.rate), 2) as rate")
                ])
                ->where('comics.status', '!=', ComicStatusEnum::PENDING)
                ->leftJoin('ratings', 'ratings.comic_id', '=', 'comics.id')
                ->join('users', 'users.id', '=', 'comics.user_id');

            // Select count chapter
            $data = $data
                ->addSelect(DB::raw('count(chapters.id) as chapter_count'))
                ->leftJoin('chapters', 'chapters.comic_id', '=', 'comics.id')
                ->where('chapters.status', '=', ChapterStatusEnum::APPROVED)
                ->groupBy('chapters.comic_id');

            if (auth()->check()) {
                $data = $data->selectSub(
                    "Select id from libraries
                    Where comic_id = comics.id
                    and user_id = " . user()->id,
                    'addedLibraries'
                );
            }

            if ($request->has('category') && $request->get('category') !== 'all') {
                $comicIds = Category::query()
                    ->select('comic_categories.comic_id')
                    ->join('comic_categories', 'comic_categories.category_id', '=', 'categories.id')
                    ->groupBy('comic_categories.comic_id')
                    ->where('categories.slug', $request->get('category'));

                $data->whereIn('comics.id', $comicIds);
            }

            if ($request->has('status') && (int)$request->get('status') != -1) {
                $data->where(function ($query) use ($request) {
                    return $query->where('comics.status', $request->get('status'))
                        ->orWhere('comics.status', ComicStatusEnum::DEFERED);
                });
                if ($request->get('status') == ComicStatusEnum::COMPLETED) {
                    if ($request->has('timeType') && $request->get('timeType')) {
                        if ($request->get('timeType') == TimeTypeRankingEnum::WEEKLY) {
                            $data->where('comics.completed_at', '>=', Carbon::now()->subWeek());
                        }

                        if ($request->get('timeType') == TimeTypeRankingEnum::MONTHLY) {
                            $data->where('comics.completed_at', '>=', Carbon::now()->subMonth());
                        }
                    }
                }
                if ($request->get('status') == ComicStatusEnum::ONGOING) {
                    if ($request->has('timeType') && $request->get('timeType')) {
                        if ($request->get('timeType') == TimeTypeRankingEnum::WEEKLY) {
                            $data->where('comics.updated_at', '>=', Carbon::now()->subWeek());
                        }

                        if ($request->get('timeType') == TimeTypeRankingEnum::MONTHLY) {
                            $data->where('comics.updated_at', '>=', Carbon::now()->subMonth());
                        }
                    }
                }
            }

            if ($request->has('sort') && (int)$request->get('sort') != -1) {
                if ($request->get('sort') == BrowseSortEnum::POPULAR) {
                    $data->addSelect(DB::raw('sum(view) as view_sum'))
                        ->orderBy('view_sum', 'desc');
                } else if ($request->get('sort') == BrowseSortEnum::RATING) {
                    $data->orderBy('rate', 'desc');

                    if ($request->has('timeType') && $request->get('timeType')) {
                        if ($request->get('timeType') == TimeTypeRankingEnum::WEEKLY) {
                            $data->where('ratings.created_at', '>=', Carbon::now()->subWeek());
                        }

                        if ($request->get('timeType') == TimeTypeRankingEnum::MONTHLY) {
                            $data->where('ratings.created_at', '>=', Carbon::now()->subMonth());
                        }
                    }
                } else if ($request->get('sort') == BrowseSortEnum::TIME_UPDATED) {
                    $data->orderBy('comics.updated_at', 'desc');
                }
            }

            if ($request->has('search') && $request->get('search') != 'null' &&  Str::of($request->get('search'))->trim() != '') {
                $search = Str::of($request->get('search'))->trim()->lower();

                $data->where(function ($query) use ($search) {
                    $query->where(DB::raw('LOWER(comics.name)'), 'like', '%' . $search . '%')
                        ->orWhere(DB::raw('LOWER(comics.alias)'), 'like', '%' . $search . '%')
                        ->orWhere(DB::raw('LOWER(comics.author)'), 'like', '%' . $search . '%')
                        ->orWhere(DB::raw('LOWER(users.name)'), 'like', '%' . $search . '%')
                        ->orWhere(DB::raw('LOWER(users.nickname)'), 'like', '%' . $search . '%');
                });

                $data->groupBy('comics.id');
            }

            $data = $data->paginate(10);

            $arr['data'] = $data->getCollection();
            $arr['pagination'] = $data->linkCollection();

            return $this->successResponse($arr, 'Your data have been render success.');
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function getComicForRanking(Request $request)
    {
        try {
            $data = Comic::query()
                ->with('firstCategory')
                ->addSelect([
                    'comics.id',
                    'comics.name',
                    'comics.alias',
                    'comics.slug',
                    'comics.avatar',
                    'comics.pre_view',
                    'users.name as user_name',
                    'users.nickname as user_nickname',
                ])
                ->addSelect([
                    DB::raw("ROUND(AVG(ratings.rate), 2) as rate"),
                    DB::raw("COUNT(ratings.id) as count_rate")
                ])
                ->where('comics.status', '!=', ComicStatusEnum::PENDING)
                ->leftJoin('ratings', 'ratings.comic_id', '=', 'comics.id')
                ->join('users', 'users.id', '=', 'comics.user_id');

            // Select count chapter
            $data = $data
                ->addSelect(
                    DB::raw("COUNT(chapters.view) as view")
                )
                ->leftJoin('chapters', 'chapters.comic_id', '=', 'comics.id')
                ->groupBy('chapters.comic_id');

            $data = $data
                ->groupBy('comics.id')
                ->orderBy('rate', 'desc')
                ->limit(5)
                ->get();

            return $this->successResponse($data, 'Your data have been render success.');
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }
}

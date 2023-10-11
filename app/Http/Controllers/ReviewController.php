<?php

namespace App\Http\Controllers;

use App\Http\Requests\Review\StoreRequest;
use App\Models\Rating;
use App\Models\UserLikeRatings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    use ResponseTrait;
    private $model;
    public function __construct()
    {
        $this->model = new Rating();
    }

    public function index(Request $request)
    {
        try {
            $data = $this->model
                ->addSelect([
                    'users.id as userId',
                    'users.name',
                    'users.avatar',
                ])
                ->addSelect([
                    'ratings.id as ratingId',
                    'rate',
                    'ratings.like',
                    'ratings.messages',
                    'ratings.image',
                    'ratings.created_at',
                    'ratings.updated_at',
                    'user_like_ratings.id as userLikeId',
                ])
                ->addSelect([
                    DB::raw('count(comments.id) as commentCount'),
                ])
                ->join('users', 'users.id', '=', 'ratings.user_id')
                ->leftJoin('user_like_ratings', 'user_like_ratings.rating_id', '=', 'ratings.id')
                ->leftJoin('comments', 'comments.rating_id', '=', 'ratings.id')
                ->where('ratings.comic_id', $request->comic_id)
                ->groupBy('ratings.id', 'users.id', 'user_like_ratings.id')
                ->orderBy('ratings.pin', 'desc')
                ->orderBy('ratings.updated_at', 'desc')
                ->paginate(20);

            foreach ($data as $each) {
                $each->updated_at_ago = time() - $each->updated_at_ago;
            }

            return $this->successResponse($data);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function store(StoreRequest $request)
    {
        try {
            $data = $request->validated();
            $data['user_id'] = user()->id;

            if ($request->file('image')) {
                $path = Storage::disk('public')->put("rating_images/$request->comic_slug/", $request->file('image'));
                $data['image'] = $path;
            }
            $data = $this->model->create($data);

            $data->updated_at_ago = time() - $data->updated_at_ago;
            $data->name = user()->name;
            $data->avatar = user()->avatar;

            return $this->successResponse($data, 'Thêm đánh giá thành công');
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function like($id)
    {
        try {
            $data = $this->model->query()
                ->where('id', $id)
                ->firstOrFail();

            $userLike = UserLikeRatings::query()
                ->where('user_id', user()->id)
                ->where('rating_id', $id)
                ->first();

            if ($userLike) {
                $userLike->delete();
                $data->like -= 1;
            } else {
                UserLikeRatings::query()->create([
                    'user_id' => user()->id,
                    'rating_id' => $id,
                ]);
                $data->like += 1;
            }
            $data->save();

            return $this->successResponse();
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $data = $this->model->query()
                ->where('id', $id)
                ->firstOrFail();

            $data->delete();

            return $this->successResponse();
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }
}

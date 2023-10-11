<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\StoreRequest;
use App\Models\Comment;
use App\Models\Rating;
use App\Models\UserLikeComments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CommentController extends Controller
{
    use ResponseTrait;
    private $model;
    public function __construct()
    {
        $this->model = new Comment();
    }

    public function index($ratingId)
    {
        try {
            $data = [];

            $rating = Rating::query()
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
                ->selectSub("
                    Select count(id) from comments where rating_id = ratingId
                ", 'commentCount')
                ->join('users', 'users.id', '=', 'ratings.user_id')
                ->leftJoin('user_like_ratings', 'user_like_ratings.rating_id', '=', 'ratings.id')
                ->where('ratings.id', $ratingId)
                ->first();

            $rating->updated_at_ago = time() - $rating->updated_at_ago;
            $data['rating'] = $rating;

            $comments = $this->model
                ->addSelect([
                    'users.id as userId',
                    'users.name',
                    'users.avatar',
                ])
                ->addSelect([
                    'comments.id',
                    'messages',
                    'like',
                    'pin',
                    'image',
                    'comments.created_at',
                    'comments.updated_at',
                    'user_like_comments.id as userLikeId',
                ])
                ->join('users', 'users.id', '=', 'comments.user_id')
                ->leftJoin('user_like_comments', 'user_like_comments.comment_id', '=', 'comments.id')
                ->where('comments.rating_id', $ratingId)
                ->orderBy('comments.updated_at', 'desc')
                ->get();


            foreach ($comments as $each) {
                $each->updated_at_ago = time() - $each->updated_at_ago;
            }

            $data['comments'] = $comments;

            return $this->successResponse($data);
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

            $userLike = UserLikeComments::query()
                ->where('user_id', user()->id)
                ->where('comment_id', $id)
                ->first();

            if ($userLike) {
                $userLike->delete();
                $data->like -= 1;
            } else {
                UserLikeComments::query()->create([
                    'user_id' => user()->id,
                    'comment_id' => $id,
                ]);
                $data->like += 1;
            }
            $data->save();

            return $this->successResponse();
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
                $path = Storage::disk('public')
                    ->put("comment_images/$request->comic_slug/$request->rating_id", $request->file('image'));
                $data['image'] = $path;
            }
            $data = $this->model->create($data);

            $data->updated_at_ago = time() - $data->updated_at_ago;
            $data->name = user()->name;
            $data->avatar = user()->avatar;

            return $this->successResponse($data, 'Thêm bình luận thành công');
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

<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use ResponseTrait;

    private $model;
    public function __construct()
    {
        $this->model = new Category();
    }

    public function index(Request $request)
    {
        try {
            $data = $this->model->query()
                ->select('id', 'name')
                ->where('name', 'like', '%' . $request->get('q') . '%')
                ->get();

            return $this->successResponse($data);
        } catch (\Throwable $th) {
            return $this->errorResponse('Your categories have been render fail.');
        }
    }

    public function store(StoreRequest $request)
    {
        try {
            $category = $request->validated();

            $this->model->create($category);

            return $this->successResponse([], 'Your category have been created success.');
        } catch (\Throwable $th) {
            return $this->errorResponse('Your category have been created fail.');
        }
    }
}

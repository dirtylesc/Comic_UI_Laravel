<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    use ResponseTrait;

    private $model;
    public function __construct()
    {
        $this->model = new Language();
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
}

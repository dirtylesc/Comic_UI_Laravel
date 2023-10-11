<?php

namespace App\Http\Controllers\Reader;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $model;
    public function __construct()
    {
        $this->model = new Category();
    }

    public function index($slug)
    {
    }
}

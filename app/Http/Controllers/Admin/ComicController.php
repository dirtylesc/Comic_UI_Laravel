<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ComicLanguageEnum;
use App\Enums\ComicStatusEnum;
use App\Http\Controllers\AdminController;
use App\Models\Comic;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ComicController extends AdminController
{
    private $model;
    public function __construct()
    {
        $this->model = new Comic();
        $currentRoute = 'comics';

        $languages = ComicLanguageEnum::getKeys();
        foreach ($languages as $key => $val) {
            $arrLanguages[$key] = Str::title($val);
        }

        $arrStatus = ComicStatusEnum::ArrayView1();

        view()->share([
            'currentRoute' => $currentRoute,
            'table' => "admin." . $this->model->getTable(),
            'languages' => $arrLanguages,
            'arrStatus' => $arrStatus,
        ]);
    }

    public function index()
    {
        return view('clients.admin.comic.index');
    }

    public function create()
    {
        return view('clients.admin.comic.create');
    }

    public function show($slug)
    {
        $comic = $this->model
            ->where('slug', $slug)
            ->get();

        return view('clients.admin.comic.show', [
            'comic' => $comic,
        ]);
    }

    public function edit($id)
    {
        $comic = $this->model->query()
            ->with('categories')
            ->findOrFail($id);

        return view('clients.admin.comic.edit', [
            'comic' => $comic,
        ]);
    }

    public function destroy($id)
    {
        $comic = $this->model->find($id);

        if ($comic) {
            $comic->delete();
        }

        return redirect()->route('admin.comics.index');
    }
}

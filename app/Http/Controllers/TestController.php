<?php

namespace App\Http\Controllers;

use App\Enums\BrowseSortEnum;
use App\Enums\ChapterStatusEnum;
use App\Enums\ComicStatusEnum;
use App\Enums\UserRoleEnum;
use App\Models\Category;
use App\Models\Chapter;
use App\Models\ChapterImages;
use App\Models\Comic;
use App\Models\History;
use App\Models\Teams;
use App\Models\User;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class TestController extends Controller
{
    public function test(Request $request)
    {
        $history = Teams::query()
            ->join('users', 'users.id', 'teams.user_id')
            ->where('teams.user_id', '=', user()->id)
            ->pluck('teams.id');

        return view('clients.test');
    }
}

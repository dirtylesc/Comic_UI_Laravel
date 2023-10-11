<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RankingController extends Controller
{
    public function __construct()
    {
        $currentRoute = 'ranking';
        view()->share([
            'currentRoute' => $currentRoute,
        ]);
    }

    public function index()
    {
        return view('clients.admin.ranking.index');
    }
}

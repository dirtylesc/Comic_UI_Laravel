<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProcessLoginRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;

class AdminController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $currentRouteName = Route::currentRouteName();

        $currentRoute = 'users';
        if (Str::contains($currentRouteName, 'comics')) {
            $currentRoute = 'comics';
        }

        view()->share('currentRoute', $currentRoute);
    }

    public function processLogin(ProcessLoginRequest $request)
    {
        $email = $request->get('email');
        $password = $request->get('password');
    }
}

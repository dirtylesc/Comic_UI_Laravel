<?php

namespace App\Http\Controllers;

use App\Enums\UserGenderEnum;
use App\Enums\UserRoleEnum;
use App\Http\Requests\ConfirmNewPasswordRequest;
use App\Http\Requests\ProcessLoginRequest;
use App\Http\Requests\RegisteringRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    use ResponseTrait;

    public function checkLogin()
    {
        if (auth()->check()) {
            return $this->successResponse([]);
        }
        return $this->errorResponse('');
    }

    public function registering(RegisteringRequest $request)
    {
        try {
            $user = $request->validated();

            $user['role'] = UserRoleEnum::READER;
            $user['gender'] = UserGenderEnum::SECRECY;
            $user['password'] = Hash::make($user['password']);

            $user = User::query()->create($user);

            return $this->successResponse($user, 'User created successfully');
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function login()
    {
        return view('clients.admin.login');
    }

    public function checkUser(ProcessLoginRequest $request)
    {
        try {
            $user = $request->validated();

            $userTemp = User::query()
                ->where('email', $user['email'])
                ->first();

            if (Hash::check($user['password'], $userTemp->password)) {
                return $this->successResponse([], 'Login successfully..');
            } else {
                return $this->errorResponse('Email or password is incorrect');
            }
        } catch (\Throwable $th) {
            return $this->errorResponse('Email or password is incorrect.');
        }
    }

    public function processLogin(ProcessLoginRequest $request)
    {
        $user = $request->validated();

        if (auth()->attempt($user, true)) {
            $user = User::query()->where('email', $user['email'])->first();

            return redirectTo();
        } else {
            return redirect()->back()->withErrors('Email or password is incorrect.');
        }

        return view('clients.admin.login');
    }

    public function formConfirmPassword()
    {
        return view('clients.auth.form_confirm_password');
    }

    public function confirmNewPassword(ConfirmNewPasswordRequest $request)
    {
        $password = $request->validated();
        user()->password = Hash::make($password['password']);
        user()->save();

        return redirectTo();
    }

    public function vertifyEmail()
    {
        try {
            event(new Registered(user()));
            return $this->successResponse([], 'Resend vertified email successfully. <br> Please check your email!');
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function callback($provider)
    {
        $githubUser = Socialite::driver($provider)->user();

        $user = User::query()
            ->where('email', $githubUser->getEmail())
            ->first();

        if (is_null($user)) {
            $user = new User();

            $user->email = $githubUser->getEmail();
            $user->role = UserRoleEnum::READER;
        }

        $user->name = $githubUser->getName();
        $user->avatar = $githubUser->getAvatar();
        $user->nickname = $githubUser->getNickname();
        $user->gender = UserGenderEnum::SECRECY;

        if ($provider === 'github') {
            $user->location = $githubUser['location'];
        }
        $user->save();

        auth()->login($user);

        if (!auth()->user()->password) {
            return redirect()->route('form_confirm_password');
        }
        // else if (!auth()->user()->email_verified_at) {
        //     return redirect()->route('verify_email');
        // }
        else return redirectTo();
    }

    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('reader.index');
    }
}

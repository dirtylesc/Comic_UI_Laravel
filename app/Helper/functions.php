<?php

use App\Enums\UserGenderEnum;
use App\Enums\UserRoleEnum;
use Carbon\Carbon;
use Illuminate\Support\Str;

if (!function_exists('user')) {
    function user(): ?object
    {
        return auth()->user();
    }
}

if (!function_exists('isAdmin')) {
    function isAdmin(): bool
    {
        return user()->role === UserRoleEnum::ADMIN;
    }
}

if (!function_exists('isSuperAdmin')) {
    function isSuperAdmin(): bool
    {
        return user()->role === UserRoleEnum::SUPER_ADMIN;
    }
}

if (!function_exists('getRoleByKey')) {
    function getRoleByKey($key)
    {
        return UserRoleEnum::getKey($key);
    }
}

if (!function_exists('titleArray')) {
    function titleArray($arr, $search = '', $replace = '')
    {
        return array_map(function ($item) use ($search, $replace) {
            return Str::title(Str::replace($search, $replace, $item));
        }, $arr);
    }
}

if (!function_exists('redirectTo')) {
    function redirectTo()
    {
        if (user()->role === UserRoleEnum::SUPER_ADMIN) {
            return redirect()->route('admin.index');
        } else {
            $role = Str::lower(getRoleByKey(user()->role));

            $role === 'translator' ? 'reader' : $role;

            return redirect()->route("$role.index");
        }
    }
}

if (!function_exists('parseTimezone')) {
    function parseTimezone($value)
    {
        return Carbon::parse($value, 'Asia/Ho_Chi_Minh');
    }
}

if (!function_exists('getGenderName')) {
    function getGenderName($gender)
    {
        return ($gender === UserGenderEnum::MALE) ? 'Male' : 'Female';
    }
}

if (!function_exists('calculateViewComic')) {
    function calculateViewComic($arrChapters)
    {
        if (count($arrChapters) == 0) {
            return 0;
        }

        foreach ($arrChapters as $each) {
            $arrView[] = $each->view;
        }
        return array_sum($arrView);
    }
}

if (!function_exists('floatToInt')) {
    function floatToInt($n)
    {
        if (str_split($n)[strlen($n) - 1] === '0') {
            return (int) $n;
        }

        return $n;
    }
}

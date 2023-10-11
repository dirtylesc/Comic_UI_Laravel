<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class ComicStatusEnum extends Enum
{
    public const ONGOING = 0;
    public const COMPLETED = 1;
    public const UNRELEASED = 2;
    public const DEFERED = 3;
    public const PENDING = 4;

    public static function ArrayView()
    {
        return [
            'Đang tiến hành' => self::ONGOING,
            'Hoàn thành' => self::COMPLETED,
            'Chưa phát hành' => self::UNRELEASED,
            'Tạm hoãn' => self::DEFERED,
            'Pending' => self::PENDING,
        ];
    }

    public static function ArrayView1()
    {
        return [
            'Ongoing' => self::ONGOING,
            'Completed' => self::COMPLETED,
            'Unreleased' => self::UNRELEASED,
            'Defered' => self::DEFERED,
            'Pending' => self::PENDING,
        ];
    }

    public static function ArrayViewBrowse()
    {
        return [
            'Ongoing' => self::ONGOING,
            'Completed' => self::COMPLETED,
        ];
    }

    public static function getKeyByValue($value)
    {
        return array_search($value, self::ArrayView1(), true);
    }
}

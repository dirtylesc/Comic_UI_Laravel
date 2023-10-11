<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class UserGenderEnum extends Enum
{
    const MALE = 0;
    const FEMALE = 1;
    const SECRECY = 2;

    public static function ArrayView()
    {
        return [
            'Male' => self::MALE,
            'Female' => self::FEMALE,
            'Secrecy' => self::SECRECY,
        ];
    }
}

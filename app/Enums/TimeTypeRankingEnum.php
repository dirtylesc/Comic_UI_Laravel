<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class TimeTypeRankingEnum extends Enum
{
    const TOTAL   = 0;
    const WEEKLY  = 1;
    const MONTHLY = 2;

    public static function ArrayView(): array
    {
        return [
            'Total' => self::TOTAL,
            'Weekly' => self::WEEKLY,
            'Monthly' => self::MONTHLY,
        ];
    }
}

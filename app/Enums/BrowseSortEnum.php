<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class BrowseSortEnum extends Enum
{
    const POPULAR = 0;
    const RATING = 1;
    const TIME_UPDATED = 2;

    public static function ArrayView()
    {
        return [
            self::POPULAR => 'Popular',
            self::RATING => 'Rating',
            self::TIME_UPDATED => 'Time Updated',
        ];
    }
}

<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class ComicLanguageEnum extends Enum
{
    public const MANGA = 0;
    public const MANHWA = 1;
    public const MANHUA = 2;
}

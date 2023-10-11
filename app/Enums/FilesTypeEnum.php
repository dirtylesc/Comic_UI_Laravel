<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class FilesTypeEnum extends Enum
{
    const WEEKLY_COMIC = 0;
    const BANNER = 1;
}

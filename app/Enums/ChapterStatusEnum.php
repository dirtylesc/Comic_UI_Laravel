<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class ChapterStatusEnum extends Enum
{
    public const PENDING  =  0;
    public const APPROVED =  1;
}

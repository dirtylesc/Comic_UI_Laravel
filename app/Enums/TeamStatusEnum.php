<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class TeamStatusEnum extends Enum
{
    public const APPROVED  =  0;
    public const PENDING =  1;
    public const DELETED =  2;
}

<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class RankNameRankingEnum extends Enum
{
    const POWER  = 'Power';
    const TRENDING = 'Trending';
    const NEW   = 'New';
}

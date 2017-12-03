<?php

declare(strict_types=1);

namespace OnceUponATime\Domain\Entity;

/**
 * @author    Samir Boulil <samir.boulil@akeneo.com>
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Leaderboard
{
    /** @var array */
    private $ranks;

    public function generateRanking(): array
    {
        return [];
    }

    public function addRank(Rank $rank): void
    {
        $this->ranks = $rank;
    }
}

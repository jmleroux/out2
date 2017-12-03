<?php

declare(strict_types=1);

namespace OnceUponATime\Domain\Entity;

/**
 * @author    Samir Boulil <samir.boulil@akeneo.com>
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Rank
{
    /** @var UserId */
    private $userId;

    /** @var Position */
    private $position;

    /** @var Points */
    private $points;

    /**
     * TODO: Find a proper name with static constructor ? but what name would work here ?
     */
    public function __construct(UserId $userId, Position $position, Points $points)
    {
        $this->userId = $userId;
        $this->position = $position;
        $this->points = $points;
    }

    public function position(): Position
    {
        return $this->position;
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function points(): Points
    {
        return $this->points;
    }

    public function comparedTo(Rank $rank2): int
    {
        return $this->position->comparedTo($rank2->position);
    }
}

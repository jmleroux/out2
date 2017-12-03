<?php

declare(strict_types=1);

namespace Tests\Unit\OnceUponATime\Domain\Entity;

use OnceUponATime\Domain\Entity\Leaderboard;
use OnceUponATime\Domain\Entity\Points;
use OnceUponATime\Domain\Entity\Position;
use OnceUponATime\Domain\Entity\Rank;
use OnceUponATime\Domain\Entity\UserId;
use PHPUnit\Framework\TestCase;

/**
 * @author    Samir Boulil <samir.boulil@akeneo.com>
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class LeaderboardTest extends TestCase
{
    /**
     * @test
     */
    public function it_is_constructed_empty()
    {
        $leaderboard = new Leaderboard();
        $this->assertSame([], $leaderboard->generateRanking());
    }

    /**
     * @test
     */
    public function it_can_add_ranks_to_it_and_generate_the_leaderboard_ordered_in_ascending()
    {
        $userId = UserId::fromString('11111111-1111-43aa-aba3-8626fecd39e8');
        $position = Position::fromInteger(1);
        $points = Points::fromInteger(1500);
        $rank1 = new Rank($userId, $position, $points);

        $userId = UserId::fromString('11111111-2222-43aa-aba3-8626fecd39e8');
        $position = Position::fromInteger(1);
        $points = Points::fromInteger(1500);
        $rankEqual = new Rank($userId, $position, $points);

        $userId = UserId::fromString('22222222-ad15-43aa-aba3-8626fecd39e8');
        $position = Position::fromInteger(2);
        $points = Points::fromInteger(1000);
        $rank2 = new Rank($userId, $position, $points);

        $leaderboard = new Leaderboard();
        $leaderboard->addRank($rank2);
        $leaderboard->addRank($rank1);
        $leaderboard->addRank($rank1);
        $this->assertSame([$rank1, $rank2], $leaderboard->generateRanking());
    }
}

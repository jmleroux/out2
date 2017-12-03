<?php

declare(strict_types=1);

namespace Tests\Unit\OnceUponATime\Domain\Entity;

use OnceUponATime\Domain\Entity\Points;
use OnceUponATime\Domain\Entity\Position;
use OnceUponATime\Domain\Entity\Rank;
use OnceUponATime\Domain\Entity\UserId;
use PHPUnit\Framework\TestCase;

/**
 * @author    Samir Boulil <samir.boulil@akeneo.com>
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class RankTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_be_constructed_with_a_user_id_a_positition_and_a_number_of_points()
    {
        $userId = UserId::fromString('3a021c08-ad15-43aa-aba3-8626fecd39a7');
        $position = Position::fromInteger(1);
        $points = Points::fromInteger(1500);

        $rank = new Rank($userId, $position, $points);

        $this->assertSame($userId, $rank->userId());
        $this->assertSame($position, $rank->position());
        $this->assertSame($points, $rank->points());
    }

    /**
     * @test
     */
    public function it_can_be_compared_to_another_rank()
    {
        $userId = UserId::fromString('11111111-ad15-43aa-aba3-8626fecd39e8');
        $position = Position::fromInteger(1);
        $points = Points::fromInteger(1500);
        $rank1 = new Rank($userId, $position, $points);

        $userId = UserId::fromString('22222222-ad15-43aa-aba3-8626fecd39e8');
        $position = Position::fromInteger(2);
        $points = Points::fromInteger(1000);
        $rank2 = new Rank($userId, $position, $points);

        $this->assertSame(1, $rank1->comparedTo($rank2));
        $this->assertSame(0, $rank1->comparedTo($rank1));
        $this->assertSame(-1, $rank2->comparedTo($rank1));
    }
}

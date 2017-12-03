<?php

declare(strict_types=1);

namespace Tests\Unit\OnceUponATime\Domain\Entity;

use OnceUponATime\Domain\Entity\Position;
use PHPUnit\Framework\TestCase;

/**
 * @author    Samir Boulil <samir.boulil@akeneo.com>
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class PositionTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_be_constructed_from_an_integer()
    {
        $rank = 1;
        $position = Position::fromInteger($rank);
        $this->assertSame((string) $rank, (string) $position);
    }

    /**
     * @test
     */
    public function it_can_only_be_constructed_with_an_integer()
    {
        $this->expectException(\InvalidArgumentException::class);
        $rank = Position::fromInteger('hello');
    }

    /**
     * @test
     */
    public function it_can_be_compared_to_another_rank()
    {
        $first = Position::fromInteger(1);
        $second = Position::fromInteger(2);
        $this->assertEquals(1, $first->comparedTo($second));
        $this->assertEquals(0, $first->comparedTo($first));
        $this->assertEquals(-1, $second->comparedTo($first));
    }

//    /**
//     * @test
//     */
//    public function it_can_be_cast_to_a_string()
//    {
//        $first = Position::fromInteger(1);
//        $second = Position::fromInteger(2);
//        $third = Position::fromInteger(3);
//        $four = Position::fromInteger(4);
//
//        $this->assertSame('First', (string) $first);
//        $this->assertSame('Second', (string) $second);
//        $this->assertSame('Third', (string) $third);
//        $this->assertSame('4', (string) $four);
//    }
}

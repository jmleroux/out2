<?php

declare(strict_types=1);

namespace OnceUponATime\Domain\Entity;

use Assert\Assertion;

/**
 * @author    Samir Boulil <samir.boulil@akeneo.com>
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Position
{
    /** @var int */
    private $rank;

    public static function fromInteger($rank): Position
    {
        Assertion::integer($rank);

        $position = new self();
        $position->rank = $rank;

        return $position;
    }

    public function __toString(): string
    {
        return (string) $this->rank;
    }

    public function comparedTo(Position $anotherPosition): int
    {
        if ($this->rank < $anotherPosition->rank) {
            return 1;
        }

        if ($this->rank === $anotherPosition->rank) {
            return 0;
        }

        return -1;
    }
}

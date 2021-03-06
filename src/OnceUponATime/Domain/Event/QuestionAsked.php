<?php

declare(strict_types=1);

namespace OnceUponATime\Domain\Event;

use OnceUponATime\Domain\Entity\Question\QuestionId;
use OnceUponATime\Domain\Entity\User\UserId;

/**
 * @author    Samir Boulil <samir.boulil@akeneo.com>
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
final class QuestionAsked implements QuizEvent
{
    /** @var QuestionId */
    private $questionId;

    /** @var UserId */
    private $userId;

    public function __construct(UserId $userId, QuestionId $questionId)
    {
        $this->questionId = $questionId;
        $this->userId = $userId;
    }

    public function questionId(): QuestionId
    {
        return $this->questionId;
    }

    public function userId(): UserId
    {
        return $this->userId;
    }
}

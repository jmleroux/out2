<?php

declare(strict_types=1);

namespace Tests\Unit\OnceUponATime\Application;

use OnceUponATime\Application\InvalidUserId;
use OnceUponATime\Application\ShowQuestion\ShowQuestion;
use OnceUponATime\Application\ShowQuestion\ShowQuestionHandler;
use OnceUponATime\Domain\Entity\Question\Answer;
use OnceUponATime\Domain\Entity\Question\Clue;
use OnceUponATime\Domain\Entity\Question\Question;
use OnceUponATime\Domain\Entity\Question\QuestionId;
use OnceUponATime\Domain\Entity\Question\Statement;
use OnceUponATime\Domain\Entity\User\ExternalUserId;
use OnceUponATime\Domain\Entity\User\Name;
use OnceUponATime\Domain\Entity\User\User;
use OnceUponATime\Domain\Entity\User\UserId;
use OnceUponATime\Domain\Event\QuestionAsked;
use OnceUponATime\Infrastructure\Persistence\InMemory\InMemoryQuestionRepository;
use OnceUponATime\Infrastructure\Persistence\InMemory\InMemoryQuizEventStore;
use OnceUponATime\Infrastructure\Persistence\InMemory\InMemoryUserRepository;
use PHPUnit\Framework\TestCase;

/**
 * @author    Samir Boulil <samir.boulil@akeneo.com>
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class ShowQuestionHandlerTest extends TestCase
{
    private const QUESTION_ID = '7d7fd0b2-0cb5-42ac-b697-3f7bfce24df9';
    private const USER_ID = '3a021c08-ad15-43aa-aba3-8626fecd39a7';

    /** @var ShowQuestionHandler */
    private $showQuestionHandler;

    public function setUp()
    {
        $question = Question::ask(
            QuestionId::fromString(self::QUESTION_ID),
            Statement::fromString('What is the most scared of an elephant ?'),
            Answer::fromString('<@right_answer>'),
            Clue::fromString('Clue 1'),
            Clue::fromString('Clue 2')
        );
        $questionRepository = new InMemoryQuestionRepository();
        $questionRepository->add($question);

        $userId = UserId::fromString(self::USER_ID);
        $externalUserId = ExternalUserId::fromString('<@testUser>');
        $name = Name::fromString('Alice Jardin');
        $user = User::register($userId, $externalUserId, $name);

        $userRepository = new InMemoryUserRepository();
        $userRepository->add($user);

        $questionAsked = new QuestionAsked($userId, QuestionId::fromString(self::QUESTION_ID));
        $quizEventStore = new InMemoryQuizEventStore();
        $quizEventStore->add($questionAsked);

        $this->testEventSubscriber = new TestEventSubscriber();

        $this->showQuestionHandler = new ShowQuestionHandler(
            $userRepository,
            $questionRepository,
            $quizEventStore
        );
    }

    /**
     * @test
     */
    public function it_shows_the_current_question_of_the_user()
    {
        $showQuestion = new ShowQuestion();
        $showQuestion->userId = self::USER_ID;
        $question = $this->showQuestionHandler->handle($showQuestion);
        $this->assertTrue(QuestionId::fromString(self::QUESTION_ID)->equals($question->id()));
    }

    /**
     * @test
     */
    public function it_throws_when_the_user_id_is_not_known()
    {
        $this->expectException(InvalidUserId::class);
        $showQuestion = new ShowQuestion();
        $showQuestion->userId = '00000000-0000-0000-0000-000000000000';
        $this->showQuestionHandler->handle($showQuestion);
    }
}

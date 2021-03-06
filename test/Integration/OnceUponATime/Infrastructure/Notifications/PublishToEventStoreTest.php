<?php

namespace Tests\Integration\OnceUponATime\Infrastructure\Notifications;

use OnceUponATime\Domain\Entity\Question\QuestionId;
use OnceUponATime\Domain\Entity\User\UserId;
use OnceUponATime\Domain\Event\QuestionAnswered;
use OnceUponATime\Infrastructure\Notifications\PublishToEventStore;
use OnceUponATime\Infrastructure\Persistence\InMemory\InMemoryQuizEventStore;
use PHPUnit\Framework\TestCase;

class PublishToEventStoreTest extends TestCase
{
    /**
     * @test
     */
    public function it_is_publishes_to_the_event_store_from_which_it_is_constructed_with()
    {
        $eventStore = new InMemoryQuizEventStore();
        $publisher = new PublishToEventStore($eventStore);
        $questionAnswered = $this->createQuestionAnswered();
        $publisher->questionAnswered($questionAnswered);

        $this->assertSame([$questionAnswered], $eventStore->all());
    }

    private function createQuestionAnswered(): QuestionAnswered
    {
        return new QuestionAnswered(
            UserId::fromString('7d7fd0b2-0cb5-42ac-b697-3f7bfce24df9'),
            QuestionId::fromString('7d7fd0b2-0cb5-42ac-b697-3f7bfce24df9'),
            true
        );
    }
}

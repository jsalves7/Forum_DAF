<?php

namespace App\Application\Answers;

use App\Domain\Answers\AnswersRepository;
use App\Domain\Answers\Specification\AcceptedAnswer;
use App\Domain\Answers\Specification\AnswerOwner;
use App\Domain\Events\EventPublisher;
use App\Domain\Exceptions\InvalidAnswerOwner;
use App\Domain\Exceptions\InvalidAnswerState;

class DeleteAnswerHandler
{
    /**
     * @var AnswersRepository
     */
    private $answers;
    /**
     * @var AnswerOwner
     */
    private $answerOwner;
    /**
     * @var AcceptedAnswer
     */
    private $acceptedAnswer;
    /**
     * @var EventPublisher
     */
    private $eventPublisher;

    /**
     * DeleteAnswerHandler constructor.
     * @param AnswersRepository $answers
     * @param AnswerOwner $answerOwner
     * @param AcceptedAnswer $acceptedAnswer
     * @param EventPublisher $eventPublisher
     */
    public function __construct(
        AnswersRepository $answers,
        AnswerOwner $answerOwner,
        AcceptedAnswer $acceptedAnswer,
        EventPublisher $eventPublisher
    ) {
        $this->answers = $answers;
        $this->answerOwner = $answerOwner;
        $this->acceptedAnswer = $acceptedAnswer;
        $this->eventPublisher = $eventPublisher;
    }

    public function handle(DeleteAnswerCommand $command)
    {
        $answer = $this->answers->withId($command->answerId());

        if (!$this->answerOwner->isSatisfiedBy($answer)) {
            throw new InvalidAnswerOwner(
                "Only the answer's owner can delete this question."
            );
        }

        if (!$this->acceptedAnswer->isSatisfiedBy($answer)) {
            throw new InvalidAnswerState(
                "Its only possible to delete an unaccepted answer. This answer is already accepted."
            );
        }

        $this->eventPublisher->publishEventsFrom($this->answers->remove($answer));
    }
}

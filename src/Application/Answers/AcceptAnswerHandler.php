<?php

namespace App\Application\Answers;

use App\Domain\Answers\Answer;
use App\Domain\Answers\AnswersRepository;
use App\Domain\Events\EventPublisher;
use App\Domain\Exceptions\InvalidQuestionOwner;
use App\Domain\Questions\Question;
use App\Domain\Questions\Specification\QuestionOwner;

class AcceptAnswerHandler
{
    /**
     * @var AnswersRepository
     */
    private $answers;
    /**
     * @var QuestionOwner
     */
    private $questionOwner;
    /**
     * @var EventPublisher
     */
    private $eventPublisher;

    /**
     * AcceptAnswerHandler constructor.
     *
     * @param AnswersRepository $answers
     * @param QuestionOwner $questionOwner
     * @param EventPublisher $eventPublisher
     */
    public function __construct(
        AnswersRepository $answers,
        QuestionOwner $questionOwner,
        EventPublisher $eventPublisher
    ) {
        $this->answers = $answers;
        $this->questionOwner = $questionOwner;
        $this->eventPublisher = $eventPublisher;
    }

    public function handle(AcceptAnswerCommand $command): Answer
    {
        $answer = $this->answers->withId($command->answerId());

        if (!$this->questionOwner->isSatisfiedBy()) {
            throw new InvalidQuestionOwner(
                "Only the question's owner can accept this answer."
            );
        }

        $this->eventPublisher->publishEventsFrom(
            $this->answers->update(
                $answer->setAsAccepted()
            )
        );

        return $answer;
    }
}

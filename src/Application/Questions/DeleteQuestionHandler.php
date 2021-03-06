<?php

namespace App\Application\Questions;

use App\Domain\Events\EventPublisher;
use App\Domain\Exceptions\InvalidQuestionOwner;
use App\Domain\Questions\Events\QuestionWasDeleted;
use App\Domain\Questions\QuestionsRepository;
use App\Domain\Questions\Specification\QuestionOwner;

class DeleteQuestionHandler
{
    /**
     * @var QuestionsRepository
     */
    private $questions;
    /**
     * @var QuestionOwner
     */
    private $questionOwner;
    /**
     * @var EventPublisher
     */
    private $eventPublisher;

    /**
     * DeleteQuestionHandler constructor.
     *
     * @param QuestionsRepository $questions
     * @param QuestionOwner $questionOwner
     * @param EventPublisher $eventPublisher
     */
    public function __construct(QuestionsRepository $questions, QuestionOwner $questionOwner, EventPublisher $eventPublisher)
    {
        $this->questions = $questions;
        $this->questionOwner = $questionOwner;
        $this->eventPublisher = $eventPublisher;
    }

    /**
     * @param DeleteQuestionCommand $command
     * @return \App\Domain\Questions\Question
     * @throws \Exception
     */
    public function handle(DeleteQuestionCommand $command)
    {
        $question = $this->questions->withId($command->questionId());

        if (!$this->questionOwner->isSatisfiedBy($question)) {
            throw new InvalidQuestionOwner(
                "Only the question's owner can delete this question."
            );
        }

        $this->questions->remove($question);
        $this->eventPublisher->publish(new QuestionWasDeleted($question));
        return $question;
    }

}

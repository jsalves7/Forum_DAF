<?php

namespace App\Application\Questions;

use App\Domain\Events\EventPublisher;
use App\Domain\Exceptions\InvalidQuestionOwner;
use App\Domain\Exceptions\InvalidQuestionState;
use App\Domain\Questions\Question;
use App\Domain\Questions\QuestionsRepository;
use App\Domain\Questions\Specification\OpenQuestion;
use App\Domain\Questions\Specification\QuestionOwner;

class EditQuestionHandler
{
    /**
     * @var QuestionsRepository
     */
    private $questions;
    /**
     * @var OpenQuestion
     */
    private $openQuestion;
    /**
     * @var QuestionOwner
     */
    private $questionOwner;
    /**
     * @var EventPublisher
     */
    private $eventPublisher;

    /**
     * Creates a EditQuestionHandler
     *
     * @param QuestionsRepository $questions
     * @param OpenQuestion $openQuestion
     * @param QuestionOwner $questionOwner
     */
    public function __construct(QuestionsRepository $questions, OpenQuestion $openQuestion, QuestionOwner $questionOwner, EventPublisher $eventPublisher)
    {
        $this->questions = $questions;
        $this->openQuestion = $openQuestion;
        $this->questionOwner = $questionOwner;
        $this->eventPublisher = $eventPublisher;
    }

    /**
     * @param EditQuestionCommand $command
     *
     * @return Question
     *
     * @throws \Exception
     */
    public function handle(EditQuestionCommand $command): Question
    {
        $question = $this->questions->withId($command->questionId());

        if (!$this->questionOwner->isSatisfiedBy($question)) {
            throw new InvalidQuestionOwner(
                "Only the question's owner can edit this question."
            );
        }

        if(!$this->openQuestion->isSatisfiedBy($question)) {
            throw new InvalidQuestionState(
                "Its only possible to edit an open question. This question is already closed."
            );
        }

        $this->eventPublisher->publishEventsFrom(
            $this->questions->update(
                $question->edit($command->question(), $command->description())
            )
        );
        return $question;
    }
}

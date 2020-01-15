<?php

namespace App\Application\Answers;

use App\Domain\Answers\Answer;
use App\Domain\Answers\AnswersRepository;
use App\Domain\Answers\Specification\AcceptedAnswer;
use App\Domain\Answers\Specification\AnswerOwner;
use App\Domain\Exceptions\InvalidAnswerOwner;
use App\Domain\Exceptions\InvalidAnswerState;

class EditAnswerHandler
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
     * Creates a EditAnswerHandler
     *
     * @param AnswersRepository $answers
     * @param AnswerOwner $answerOwner
     * @param AcceptedAnswer $acceptedAnswer
     */
    public function __construct(AnswersRepository $answers, AnswerOwner $answerOwner, AcceptedAnswer $acceptedAnswer)
    {
        $this->answers = $answers;
        $this->answerOwner = $answerOwner;
        $this->acceptedAnswer = $acceptedAnswer;
    }

    public function handle(EditAnswerCommand $command): Answer
    {
        $answer = $this->answers->withId($command->answerId());

        if (!$this->answerOwner->isSatisfiedBy($answer)) {
            throw new InvalidAnswerOwner(
                "Only the answer's owner can edit this question."
            );
        }

        if (!$this->acceptedAnswer->isSatisfiedBy($answer)) {
            throw new InvalidAnswerState(
                "Its only possible to edit an unaccepted answer. This answer is already accepted."
            );
        }

        return $this->answers->update(
            $answer->edit($command->description())
        );
    }
}

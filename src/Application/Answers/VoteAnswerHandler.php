<?php

namespace App\Application\Answers;

use App\Domain\Answers\Answer;
use App\Domain\Answers\AnswersRepository;
use App\Domain\Events\EventPublisher;
use App\Domain\Exceptions\InvalidUserVote;
use App\Domain\Questions\QuestionsRepository;
use App\Domain\Votes\Specification\UserVote;

class VoteAnswerHandler
{
    /**
     * @var AnswersRepository
     */
    private $answers;
    /**
     * @var QuestionsRepository
     */
    private $questions;
    /**
     * @var UserVote
     */
    private $userVote;
    /**
     * @var EventPublisher
     */
    private $eventPublisher;

    /**
     * VoteAnswerHandler constructor.
     *
     * @param AnswersRepository $answers
     * @param QuestionsRepository $questions
     * @param UserVote $userVote
     * @param EventPublisher $eventPublisher
     */
    public function __construct(
        AnswersRepository $answers,
        QuestionsRepository $questions,
        UserVote $userVote,
        EventPublisher $eventPublisher
    ) {
        $this->answers = $answers;
        $this->questions = $questions;
        $this->userVote = $userVote;
        $this->eventPublisher = $eventPublisher;
    }

    public function handle(VoteAnswerCommand $command): Answer
    {
        $answer = $this->answers->withId($command->answerId());

        if (!$this->userVote->isSatisfiedBy($answer)) {
            throw new InvalidUserVote(
                "You already voted for this question!"
            );
        }
        $this->eventPublisher->publishEventsFrom(
            $this->answers->update(
                $answer->addVote($command->vote())
            )
        );

        return $answer;
    }
}

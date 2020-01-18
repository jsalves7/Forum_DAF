<?php

namespace App\Application\Answers;

use App\Domain\Answers\Answer;
use App\Domain\Answers\AnswersRepository;
use App\Domain\Events\EventPublisher;

class AddAnswerHandler
{
    /**
     * @var AnswersRepository
     */
    private $repository;
    /**
     * @var EventPublisher
     */
    private $eventPublisher;

    /**
     * Creates an AddAnswerHandler
     *
     * @param AnswersRepository $repository
     * @param EventPublisher $eventPublisher
     */
    public function __construct(AnswersRepository $repository, EventPublisher $eventPublisher)
    {
        $this->repository = $repository;
        $this->eventPublisher = $eventPublisher;
    }

    /**
     * Handles add answer command
     *
     * @param AddAnswerCommand $command
     *
     * @return Answer
     *
     * @throws \Exception
     */
    public function handle(AddAnswerCommand $command): Answer
    {
        $answer = new Answer(
            $command->questionId(),
            $command->userId(),
            $command->description()
        );

        $this->eventPublisher->publishEventsFrom($this->repository->add($answer));
        return $answer;
    }
}

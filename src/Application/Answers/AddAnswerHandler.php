<?php

namespace App\Application\Answers;

use App\Domain\Answers\Answer;
use App\Domain\Answers\AnswersRepository;

class AddAnswerHandler
{
    /**
     * @var AnswersRepository
     */
    private $repository;

    /**
     * Creates an AddAnswerHandler
     *
     * @param AnswersRepository $repository
     */
    public function __construct(AnswersRepository $repository)
    {
        $this->repository = $repository;
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

        return $this->repository->add($answer);
    }
}

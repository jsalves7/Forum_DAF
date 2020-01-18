<?php

namespace App\Domain\Answers\Events;

use App\Domain\Answers\Answer;
use App\Domain\Events\AbstractDomainEvent;
use App\Domain\Events\DomainEvent;

class AnswerWasCreated extends AbstractDomainEvent implements DomainEvent
{
    /**
     * @var Answer
     */
    private $answer;

    /**
     * AnswerWasCreated constructor.
     *
     * @param Answer $answer
     * @throws \Exception
     */
    public function __construct(Answer $answer)
    {
        parent::__construct();
        $this->answer = $answer;
    }

    /**
     * Creates Answer
     *
     * @return Answer
     */
    public function answer(): Answer
    {
        return $this->answer;
    }



}

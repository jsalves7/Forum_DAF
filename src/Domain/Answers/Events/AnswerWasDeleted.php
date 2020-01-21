<?php

namespace App\Domain\Answers\Events;

use App\Domain\Answers\Answer;
use App\Domain\Events\AbstractDomainEvent;
use App\Domain\Events\DomainEvent;

class AnswerWasDeleted extends AbstractDomainEvent implements DomainEvent
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

    public function answer(): Answer
    {
        return $this->answer;
    }


}

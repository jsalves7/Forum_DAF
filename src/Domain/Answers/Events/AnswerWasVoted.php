<?php

namespace App\Domain\Answers\Events;

use App\Domain\Answers\Answer\AnswerId;
use App\Domain\Events\AbstractDomainEvent;
use App\Domain\Events\DomainEvent;
use App\Domain\Votes\Vote;

class AnswerWasVoted extends AbstractDomainEvent implements DomainEvent
{
    /**
     * @var AnswerId
     */
    private $answerId;
    /**
     * @var Vote
     */
    private $vote;

    /**
     * AnswerWasVoted constructor.
     * @param AnswerId $answerId
     * @param Vote $vote
     * @throws \Exception
     */
    public function __construct(AnswerId $answerId, Vote $vote)
    {
        parent::__construct();
        $this->answerId = $answerId;
        $this->vote = $vote;
    }

    public function answerId(): AnswerId
    {
        return $this->answerId;
    }

    public function vote(): Vote
    {
        return $this->vote;
    }

}

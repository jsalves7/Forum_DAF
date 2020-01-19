<?php

namespace App\Application\Answers;

use App\Domain\Answers\Answer\AnswerId;
use App\Domain\Votes\Vote;

class VoteAnswerCommand
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
     * VoteAnswerCommand constructor.
     * @param AnswerId $answerId
     * @param Vote $vote
     */
    public function __construct(AnswerId $answerId, Vote $vote)
    {
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

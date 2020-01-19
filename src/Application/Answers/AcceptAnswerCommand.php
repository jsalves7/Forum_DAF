<?php

namespace App\Application\Answers;

use App\Domain\Answers\Answer\AnswerId;

class AcceptAnswerCommand
{
    /**
     * @var AnswerId
     */
    private $answerId;

    /**
     * AcceptAnswerCommand constructor.
     *
     * @param AnswerId $answerId
     */
    public function __construct(AnswerId $answerId)
    {
        $this->answerId = $answerId;
    }

    public function answerId(): AnswerId
    {
       return $this->answerId;
    }
}

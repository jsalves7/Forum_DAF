<?php

namespace App\Domain\Votes\Specification;

use App\Domain\Answers\Answer;
use App\Domain\Votes\VoteSpecification;

class UserVote implements VoteSpecification
{
    /**
     * @inheritDoc
     */
    public function isSatisfiedBy(Answer $answer): bool
    {
        return $answer->isVoted();
    }
}

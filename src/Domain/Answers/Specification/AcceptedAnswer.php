<?php

namespace App\Domain\Answers\Specification;

use App\Domain\Answers\Answer;
use App\Domain\Answers\AnswerSpecification;

class AcceptedAnswer implements AnswerSpecification
{
    /**
     * @inheritDoc
     */
    public function isSatisfiedBy(Answer $answer): bool
    {
        return $answer->isAccepted();
    }
}

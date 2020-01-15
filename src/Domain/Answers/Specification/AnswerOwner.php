<?php

namespace App\Domain\Answers\Specification;

use App\Domain\Answers\Answer;
use App\Domain\Answers\AnswerSpecification;
use App\Domain\UserManagement\UserIdentifier;

class AnswerOwner implements AnswerSpecification
{

    private $identifier;

    public function __construct(UserIdentifier $identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * @inheritDoc
     */
    public function isSatisfiedBy(Answer $answer): bool
    {
        $currentUser = $this->identifier->currentUser();
        return $answer->userId()->equalsTo($currentUser->userId());
    }
}

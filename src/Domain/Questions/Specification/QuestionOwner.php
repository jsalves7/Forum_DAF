<?php

namespace App\Domain\Questions\Specification;

use App\Domain\Questions\Question;
use App\Domain\Questions\QuestionSpecification;
use App\Domain\UserManagement\UserIdentifier;

class QuestionOwner implements QuestionSpecification
{

    private $identifier;

    public function __construct(UserIdentifier $identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * @inheritDoc
     */
    public function isSatisfiedBy(Question $question): bool
    {
        $currentUser = $this->identifier->currentUser();
        return $question->userId()->equalsTo($currentUser->userId());
    }
}

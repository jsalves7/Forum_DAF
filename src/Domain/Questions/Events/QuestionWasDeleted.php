<?php

namespace App\Domain\Questions\Events;

use App\Domain\Events\AbstractDomainEvent;
use App\Domain\Events\DomainEvent;
use App\Domain\Questions\Question;

class QuestionWasDeleted extends AbstractDomainEvent implements DomainEvent
{
    /**
     * @var Question
     */
    private $question;

    /**
     * QuestionWasDeleted constructor.
     *
     * @param Question $question
     * @throws \Exception
     */
    public function __construct(Question $question)
    {
        parent::__construct();
        $this->question = $question;
    }

    public function question(): Question
    {
        return $this->question;
    }

}

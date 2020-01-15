<?php

namespace App\Domain\Questions\Events;

use App\Domain\Events\AbstractDomainEvent;
use App\Domain\Events\DomainEvent;
use App\Domain\Questions\Question\QuestionId;

class QuestionWasEdited extends AbstractDomainEvent implements DomainEvent
{
    /**
     * @var QuestionId
     */
    private $questionId;
    /**
     * @var string
     */
    private $question;
    /**
     * @var string
     */
    private $description;


    /**
     * QuestionWasEdited constructor.
     * @param QuestionId $questionId
     * @param string $question
     * @param string $description
     * @throws \Exception
     */
    public function __construct(QuestionId $questionId, string $question, string $description)
    {
        parent::__construct();
        $this->questionId = $questionId;
        $this->question = $question;
        $this->description = $description;
    }

    public function questionId(): QuestionId
    {
        return $this->questionId;
    }

    public function question(): string
    {
        return $this->question;
    }

    public function description(): string
    {
        return $this->description;
    }

}

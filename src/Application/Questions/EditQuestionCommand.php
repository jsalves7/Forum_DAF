<?php

namespace App\Application\Questions;

use App\Domain\Questions\Question\QuestionId;

class EditQuestionCommand
{
    private $question;
    private $description;
    private $questionId;

    public function __construct(QuestionId $questionId, $question, $description)
    {
       $this->question = $question;
       $this->description = $description;
       $this->questionId = $questionId;
    }

    public function question(): string
    {
        return $this->question;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function questionId(): QuestionId
    {
        return $this->questionId;
    }

}

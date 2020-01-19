<?php

namespace App\Application\Questions;

use App\Domain\Questions\Question\QuestionId;

class DeleteQuestionCommand
{
    /**
     * @var QuestionId
     */
    private $questionId;

    /**
     * DeleteQuestionCommand constructor.
     *
     * @param QuestionId $questionId
     */
    public function __construct(QuestionId $questionId)
    {
        $this->questionId = $questionId;
    }

    public function questionId(): QuestionId
    {
        return $this->questionId;
    }
}

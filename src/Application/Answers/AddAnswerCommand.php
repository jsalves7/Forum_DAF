<?php

namespace App\Application\Answers;

use App\Domain\Questions\Question\QuestionId;
use App\Domain\UserManagement\User\UserId;

class AddAnswerCommand
{
    /**
     * @var QuestionId
     */
    private $questionId;

    /**
     * @var UserId
     */
    private $userId;

    /**
     * @var string
     */
    private $description;

    /**
     * Creates a AddAnswerCommand
     *
     * @param QuestionId $questionId
     * @param UserId $userId
     * @param string $description
     */
    public function __construct(QuestionId $questionId, UserId $userId, string $description)
    {
        $this->questionId = $questionId;
        $this->userId = $userId;
        $this->description = $description;
    }

    public function questionId(): QuestionId
    {
        return $this->questionId;
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function description(): string
    {
        return $this->description;
    }

}

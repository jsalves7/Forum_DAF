<?php

namespace App\Application\Answers;

use App\Domain\Questions\Question\QuestionId;
use App\Domain\UserManagement\User\UserId;

/**
 * Class AddAnswerCommand
 * @package App\Application\Answers
 *
 * @OA\Schema(
 *     title="AddAnswer",
 *     schema="AddAnswer"
 * )
 */
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
     *
     * @OA\Property(example="Tonight's dinner is lasagna!")
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

/**
 * @OA\RequestBody(
 *     request="AddAnswer",
 *     description="Object containing the very minimal information needded to create an answer",
 *     required=true,
 *     @OA\JsonContent(ref="#/components/schemas/AddAnswer")
 * )
 */

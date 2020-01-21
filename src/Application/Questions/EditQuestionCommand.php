<?php

namespace App\Application\Questions;

use App\Domain\Questions\Question\QuestionId;

/**
 * Class EditQuestionCommand
 * @package App\Application\Questions
 *
 * @OA\Schema(
 *     title="UpdateQuestion",
 *     schema="UpdateQuestion"
 * )
 */
class EditQuestionCommand
{
    /**
     * @var string
     *
     * @OA\Property(example="A simple question")
     */
    private $question;

    /**
     * @var string
     *
     * @OA\Property(example="How can we do something?")
     */
    private $description;

    /**
     * @var QuestionId
     */
    private $questionId;

    /**
     * Creates a EditQuestionCommand
     *
     * @param QuestionId $questionId
     * @param string $question
     * @param string $description
     */
    public function __construct(QuestionId $questionId, string $question, string $description)
    {
        $this->question = $question;
        $this->description = $description;
        $this->questionId = $questionId;
    }

    /**
     * question
     *
     * @return string
     */
    public function question(): string
    {
        return $this->question;
    }

    /**
     * description
     *
     * @return string
     */
    public function description(): string
    {
        return $this->description;
    }

    public function questionId(): QuestionId
    {
        return $this->questionId;
    }
}

/**
 * @OA\RequestBody(
 *     request="UpdateQuestion",
 *     description="The updated question",
 *     required=true,
 *     @OA\JsonContent(ref="#/components/schemas/UpdateAnswer")
 * )
 */

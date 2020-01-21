<?php

namespace App\Application\Answers;

use App\Domain\Answers\Answer\AnswerId;

/**
 * Class EditAnswerCommand
 * @package App\Application\Answers
 *
 * @OA\Schema(
 *     title="UpdateAnswer",
 *     schema="UpdateAnswer"
 * )
 */
class EditAnswerCommand
{

    private $answerId;

    /**
     * @var string
     *
     * @OA\Property(example="Tonight's dinner is soup!")
     */
    private $description;

    public function __construct(AnswerId $answerId, $description)
    {
        $this->answerId = $answerId;
        $this->description = $description;
    }

    public function answerId(): AnswerId
    {
        return $this->answerId;
    }

    public function description(): string
    {
        return $this->description;
    }
}

/**
 * @OA\RequestBody(
 *     request="UpdateAnswer",
 *     description="The updated answer",
 *     required=true,
 *     @OA\JsonContent(ref="#/components/schemas/UpdateAnswer")
 * )
 */

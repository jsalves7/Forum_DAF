<?php

namespace App\Application\Tags;

use App\Domain\Questions\Question\QuestionId;

class UpdateTagsCommand
{
    /**
     * @var QuestionId
     */
    private $questionId;
    /**
     * @var array
     */
    private $tags;

    /**
     * UpdateTagsCommand constructor.
     *
     * @param QuestionId $questionId
     *
     * @param array $tags
     */
    public function __construct(QuestionId $questionId, array $tags)
    {
        $this->questionId = $questionId;
        $this->tags = $tags;
    }

    /**
     * @return QuestionId
     */
    public function questionId(): QuestionId
    {
        return $this->questionId;
    }

    /**
     * @return array|Tag[]
     */
    public function tags(): array
    {
        return $this->tags;
    }
}

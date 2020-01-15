<?php


namespace App\Domain\Questions;

/**
 * Interface QuestionSpecification
 *
 * @package Domain\Questions
 */
interface QuestionSpecification
{
    /**
     * Checks if the provided question satisfies current specification
     *
     * @param Question $question
     *
     * @return bool
     */
    public function isSatisfiedBy(Question $question): bool;
}
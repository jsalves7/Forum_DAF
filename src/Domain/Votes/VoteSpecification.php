<?php


namespace App\Domain\Votes;

use App\Domain\Answers\Answer;

/**
 * Interface VoteSpecification
 *
 * @package App\Domain\Votes
 */
interface VoteSpecification
{
    /**
     * Checks if the provided vote satisfies current specification
     *
     * @param Answer $answer
     *
     * @return bool
     */
    public function isSatisfiedBy(Answer $answer): bool;
}
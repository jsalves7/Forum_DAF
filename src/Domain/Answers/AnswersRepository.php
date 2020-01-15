<?php


namespace App\Domain\Answers;


use App\Domain\Answers\Answer\AnswerId;
use App\Domain\Exceptions\AnswerNotFound;

interface AnswersRepository
{
    /**
     * Adds an answer to the repository
     *
     * @param Answer $answer
     *
     * @return Answer
     */
    public function add(Answer $answer): Answer;

    /**
     * Retrieves the answer with the provided ID
     *
     * @param AnswerId $answerId
     *
     * @return Answer
     *
     * @throws AnswerNotFound when there is no answers with the given id
     */
    public function withId(AnswerId $answerId): Answer;

    /**
     * Persists all changes on provided answer entity
     *
     * @param Answer $answer
     *
     * @return Answer
     */
    public function update(Answer $answer): Answer;
}
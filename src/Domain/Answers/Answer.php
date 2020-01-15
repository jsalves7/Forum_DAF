<?php

namespace App\Domain\Answers;

use App\Domain\Answers\Answer\AnswerId;
use App\Domain\Questions\Question\QuestionId;
use App\Domain\UserManagement\User\UserId;
use App\Domain\Votes\Vote;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Answer
 *
 * @package App\Domain\Answers
 *
 * @ORM\Entity()
 * @ORM\Table(name="answers")
 */
class Answer
{
    /**
     * @var AnswerId
     *
     * @ORM\Id()
     * @ORM\Column(type="AnswerId", name="id")
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $answerId;

    /**
     * @var QuestionId
     *
     * @ORM\Column(type="QuestionId", name="question_id")
     */
    private $questionId;

    /**
     * @var UserId
     *
     * @ORM\Column(type="UserId", name="user_id")
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column()
     */
    private $description;

    /**
     * @var DateTimeImmutable
     *
     * @ORM\Column(type="datetime_immutable")
     */
    private $givenOn;

    /**
     * @var bool
     *
     * @ORM\Column()
     */
    private $accepted = false;

    /**
     * @var bool
     *
     * @ORM\Column()
     */
    private $voted = false;

    /**
     * @var DateTimeImmutable
     *
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $lastEditedOn;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $positiveVotes;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $negativeVotes;

    /**
     * Creates an Answer
     *
     * @param QuestionId $questionId
     * @param UserId $userId
     * @param string $description
     * @param bool $accepted
     *
     * @throws \Exception
     */
    public function __construct(QuestionId $questionId, UserId $userId, string $description, bool $accepted = false)
    {
        $this->answerId = new AnswerId();
        $this->questionId = $questionId;
        $this->userId = $userId;
        $this->description = $description;
        $this->positiveVotes = 0;
        $this->negativeVotes = 0;
        $this->accepted = $accepted;
        $this->givenOn = new DateTimeImmutable();
    }

    public function answerId(): AnswerId
    {
        return $this->answerId;
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

    public function givenOn(): DateTimeImmutable
    {
        return $this->givenOn;
    }

    public function isAccepted(): bool
    {
        return $this->accepted;
    }

    public function setAsAccepted(): bool
    {
        return $this->accepted = true;
    }

    public function edit(string $description): Answer
    {
        $this->description = $description;
        $this->lastEditedOn = new DateTimeImmutable();
        // TODO: it should register an event
        return $this;
    }

    public function lastEditedOn(): ?DateTimeImmutable
    {
        return $this->lastEditedOn;
    }

    public function isVoted(): bool
    {
        return $this->voted;
    }

    public function positiveVotes(): int
    {
        return $this->positiveVotes;
    }

    public function negativeVotes(): int
    {
        return $this->negativeVotes;
    }

    public function addVote(Vote $vote): int
    {
        if ($vote->isPositive() == true) {
            ++$this->positiveVotes;
            return $this->positiveVotes;
        }

        if ($vote->isNegative() == false) {
            ++$this->negativeVotes;
            return $this->negativeVotes;
        }
    }


}

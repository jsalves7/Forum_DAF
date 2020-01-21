<?php

namespace App\Domain\Answers;

use App\Domain\Answers\Answer\AnswerId;
use App\Domain\Answers\Events\AnswerWasAccepted;
use App\Domain\Answers\Events\AnswerWasCreated;
use App\Domain\Answers\Events\AnswerWasEdited;
use App\Domain\Answers\Events\AnswerWasVoted;
use App\Domain\Comparable;
use App\Domain\Events\EventGenerator;
use App\Domain\Events\EventGeneratorMethods;
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
 *
 * @IgnoreAnnotation("OA\Schema")
 * @IgnoreAnnotation("OA\Property")
 * @IgnoreAnnotation("OA\Items")
 *
 * @OA\Schema()
 */
class Answer implements EventGenerator, Comparable, \JsonSerializable
{

    use EventGeneratorMethods;

    /**
     * @var AnswerId
     *
     * @ORM\Id()
     * @ORM\Column(type="AnswerId", name="id")
     * @ORM\GeneratedValue(strategy="NONE")
     *
     * @OA\Property(
     *     type="string",
     *     description="Answer identifier",
     *     example="e1026e90-9b21-4b6d-b06e-9c592f7bdb82"
     * )
     *
     */
    private $answerId;

    /**
     * @var QuestionId
     *
     * @ORM\Column(type="QuestionId", name="question_id")
     *
     * @OA\Property(
     *     type="string",
     *     description="Question identifier",
     *     example="e1026e90-9b21-4b6d-b06e-9c592f7bdb82"
     * )
     */
    private $questionId;

    /**
     * @var UserId
     *
     * @ORM\Column(type="UserId", name="user_id")
     *
     * @OA\Property(
     *     type="string",
     *     description="User identifier",
     *     example="e1026e90-9b21-4b6d-b06e-9c592f7bdb82"
     * )
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column()
     *
     * @OA\Property(
     *     description="Answer body",
     *     example="Yeah, off course I can help you, it is three o’clock."
     * )
     */
    private $description;

    /**
     * @var DateTimeImmutable
     *
     * @ORM\Column(type="datetime_immutable")
     *
     * @OA\Property(
     *     ref="#/components/schemas/DateTime",
     *     description="Date and time answer was given"
     * )
     */
    private $givenOn;

    /**
     * @var bool
     *
     * @ORM\Column()
     *
     * @OA\Property(
     *     example=false,
     *     description="Flag the accepted/unaccepted answer state"
     * )
     */
    private $accepted = false;

    /**
     * @var bool
     *
     * @ORM\Column()
     *
     * @OA\Property(
     *     example=false,
     *     description="Flag the voted/non voted answer"
     * )
     */
    private $voted = false;

    /**
     * @var DateTimeImmutable
     *
     * @ORM\Column(type="datetime_immutable", nullable=true)
     *
     * @OA\Property(
     *     ref="#/components/schemas/DateTime",
     *     description="Date and time answer was last edited"
     * )
     */
    private $lastEditedOn;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     *
     * @OA\Property(
     *     description="Positive votes",
     *     example=10
     * )
     */
    private $positiveVotes;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     *
     * @OA\Property(
     *     description="Negative votes",
     *     example=5
     * )
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
        $this->recordThat(new AnswerWasCreated($this));
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

    /**
     * @return Answer
     *
     * @throws \Exception
     */
    public function setAsAccepted(): Answer
    {
        $this->accepted = true;
        $this->recordThat(new AnswerWasAccepted($this->answerId));
        return $this;
    }

    /**
     * @param string $description
     * @return Answer
     *
     * @throws \Exception
     */
    public function edit(string $description): Answer
    {
        $this->description = $description;
        $this->lastEditedOn = new DateTimeImmutable();
        $this->recordThat(new AnswerWasEdited($this->answerId, $description));
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

    /**
     * @param Vote $vote
     * @return Answer
     *
     * @throws \Exception
     */
    public function addVote(Vote $vote): Answer
    {
        if ($vote->isPositive()) {
            $this->positiveVotes++;
            $this->recordThat(new AnswerWasVoted($this->answerId, $vote));
            return $this;
        }

        $this->negativeVotes++;
        $this->recordThat(new AnswerWasVoted($this->answerId, $vote));
        return $this;
    }

    /**
     * Checks if there is other object equal to current one
     *
     * @inheritDoc
     */
    public function equalsTo($otherAnswer): bool
    {
        if(!$otherAnswer instanceof Answer) {
            return false;
        }

        return $this->answerId->equalsTo($otherAnswer->answerId());
    }


    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [
            'answerId' => $this->answerId,
            'questionId' => $this->questionId,
            'userId' => $this->userId,
            'description' => $this->description,
            'giveOn' => $this->givenOn,
            'accepted' => $this->accepted,
            'voted' => $this->voted,
            'lastEditedOn' => $this->lastEditedOn,
            'positiveVotes' => $this->positiveVotes,
            'negativeVotes' => $this->negativeVotes,
        ];
    }
}

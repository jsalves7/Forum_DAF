<?php

namespace App\Domain\Questions;

use App\Domain\Answers\Answer;
use App\Domain\Events\EventGenerator;
use App\Domain\Events\EventGeneratorMethods;
use App\Domain\Questions\Events\QuestionWasCreated;
use App\Domain\Questions\Events\QuestionWasDeleted;
use App\Domain\Questions\Events\QuestionWasEdited;
use App\Domain\Questions\Events\TagsWereUpdated;
use App\Domain\Questions\Question\QuestionId;
use App\Domain\UserManagement\User\UserId;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Exception;

/**
 * Question
 *
 * @package App\Domain\Questions
 *
 * @IgnoreAnnotation("OA\Schema")
 * @IgnoreAnnotation("OA\Property")
 * @IgnoreAnnotation("OA\Items")
 *
 * @ORM\Entity()
 * @ORM\Table(name="questions")
 *
 * @OA\Schema()
 *
 */
class Question implements EventGenerator, \JsonSerializable
{
    use EventGeneratorMethods;

    /**
     * @var QuestionId
     *
     * @ORM\Id()
     * @ORM\Column(type="QuestionId", name="id")
     * @ORM\GeneratedValue(strategy="NONE")
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
     *     description="Question made",
     *     example="What time is it?"
     * )
     */
    private $question;

    /**
     * @var string
     *
     * @ORM\Column()
     *
     * @OA\Property(
     *     description="Optional description",
     *     example="It gets hard to know what time is it when I am working. Can you help?"
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
     *     description="Date and time question was applied"
     * )
     */
    private $appliedOn;

    /**
     * @var bool
     *
     * @ORM\Column()
     *
     * @OA\Property(
     *     example=true,
     *     description="Flag the open/close question state"
     * )
     */
    private $open = true;

    /**
     * @var DateTimeImmutable
     *
     * @ORM\Column(type="datetime_immutable", nullable=true)
     *
     * @OA\Property(
     *     ref="#/components/schemas/DateTime",
     *     description="Date and time question was last edited"
     * )
     */
    private $lastEditedOn;

    /**
     * @var ArrayCollection|Tag[]
     * @ORM\ManyToMany(targetEntity="Tag")
     * @ORM\JoinTable(name="question_tags",
     *      joinColumns={@ORM\JoinColumn(name="question_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id")}
     *      )
     *
     * @OA\Property(
     *     description="Question tags",
     *     @OA\Items(ref="#/components/schemas/Tag")
     * )
     */
    private $tags;

    /**
     * @var Answer[]
     *
     * @ORM\OneToMany(targetEntity="App\Domain\Answers\Answer", mappedBy="question")
     *
     * @OA\Property(
     *     description="Question answers",
     *     title="Answers",
     *     @OA\Items(ref="#/components/schemas/Answer")
     * )
     */
    private $listOfAnswers = [];

    /**
     * Creates a Question
     *
     * @param UserId $userId
     * @param string $question
     * @param string $description
     *
     * @throws Exception
     */
    public function __construct(UserId $userId, string $question, string $description)
    {
        $this->questionId = new QuestionId();
        $this->userId = $userId;
        $this->question = $question;
        $this->description = $description;
        $this->appliedOn = new DateTimeImmutable();
        $this->tags = new ArrayCollection();
        $this->recordThat(new QuestionWasCreated($this));
    }

    /**
     * Question identifier
     *
     * @return QuestionId
     */
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

    public function question(): string
    {
        return $this->question;
    }

    public function appliedOn(): DateTimeImmutable
    {
        return $this->appliedOn;
    }

    public function isOpen(): bool
    {
        return $this->open;
    }

    /**
     * edit
     *
     * @param string $question
     * @param string $description
     *
     * @return Question
     *
     * @throws Exception
     */
    public function edit(string $question, string $description): Question
    {
        $this->question = $question;
        $this->description = $description;
        $this->lastEditedOn = new DateTimeImmutable();
        $this->recordThat(new QuestionWasEdited($this->questionId, $question, $description));
        return $this;
    }

    public function lastEditedOn(): ?DateTimeImmutable
    {
        return $this->lastEditedOn;
    }

    /**
     * tags
     *
     * @return ArrayCollection
     */
    public function tags(): ArrayCollection
    {
        return $this->tags;
    }

    /**
     * Updates question tags
     *
     * @param Collection $tags
     *
     * @return Question
     */
    public function updateTags(Collection $tags): Question
    {
        $this->tags = $tags;
        $this->recordThat(new TagsWereUpdated($this->questionId, $tags));
        return $this;
    }

    public function listOfAnswers(): array
    {
        if ($this->listOfAnswers instanceof PersistentCollection) {
            $this->listOfAnswers = $this->listOfAnswers->toArray();
        }

        return $this->listOfAnswers;
    }

    public function addAnswer(Answer $answer): Question
    {
        $this->listOfAnswers[(string) $answer->answerId()] = $answer;
        return $this;
    }

    public function acceptedAnswer(): ?Answer
    {
        foreach ($this->listOfAnswers as $answer) {
            if ($answer->isAccepted()) {
                return $answer;
            }
        }
        return null;
    }

    public function removeAnswer(Answer $answer): Question
    {
        $answersList = $this->listOfAnswers;
        $newAnswersList = [];
        foreach ($answersList as $current) {
            if ($current->answerId()->equalsTo($answer->answerId())) {
                continue;
            }
            $newAnswersList[(string) $current->answerId()] = $current;
        }

        $this->listOfAnswers = $newAnswersList;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [
            'questionId' => $this->questionId,
            'userId' => $this->userId,
            'question' => $this->question,
            'description' => $this->description,
            'appliedOn' => $this->appliedOn,
            'open' => $this->open,
            'lastEditedOn' => $this->lastEditedOn,
            'tags' => $this->tags,
            'listOfAnswers' => $this->listOfAnswers(),
            'acceptedAnswer' => $this->acceptedAnswer(),
        ];
    }
}

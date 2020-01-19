<?php

namespace spec\App\Domain\Answers;

use App\Domain\Answers\Answer;
use App\Domain\Answers\Events\AnswerWasCreated;
use App\Domain\Answers\Events\AnswerWasEdited;
use App\Domain\Answers\Events\AnswerWasVoted;
use App\Domain\Events\EventGenerator;
use App\Domain\Questions\Question\QuestionId;
use App\Domain\UserManagement\User\UserId;
use App\Domain\Votes\Vote;
use PhpSpec\ObjectBehavior;

class AnswerSpec extends ObjectBehavior
{

    private $questionId;
    private $userId;
    private $description;
    private $positiveVotes;
    private $negativeVotes;
    private $accepted;

    function let()
    {
        $this->questionId = new QuestionId();
        $this->userId = new UserId();
        $this->description = "Possible Solution";
        $this->positiveVotes = 0;
        $this->negativeVotes = 0;
        $this->accepted = false;
        $this->beConstructedWith($this->questionId, $this->userId, $this->description, $this->accepted);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Answer::class);
    }

    function its_an_event_generator()
    {
        $this->shouldBeAnInstanceOf(EventGenerator::class);
        $this->releaseEvents()[0]->shouldBeAnInstanceOf(AnswerWasCreated::class);
    }

    function it_has_an_answer_id()
    {
        $this->answerId()->shouldBeAnInstanceOf(Answer\AnswerId::class);
    }

    function it_has_a_question_id()
    {
        $this->questionId()->shouldBe($this->questionId);
    }

    function it_has_a_user_id()
    {
        $this->userId()->shouldBe($this->userId);
    }

    function it_has_a_description()
    {
        $this->description()->shouldBe($this->description);
    }

    function it_has_a_given_on_date_time()
    {
        $this->givenOn()->shouldBeAnInstanceOf(\DateTimeImmutable::class);
    }

    function it_has_an_accepted_state()
    {
        $this->isAccepted()->shouldBe(false);
    }

    function it_can_set_an_answer_as_the_accepted_one()
    {
        $this->setAsAccepted()->shouldBe(true);
    }

    /**
     * @throws \Exception
     */
    function it_can_be_edited()
    {
        $this->releaseEvents();
        $description = 'New Description';
        $this->lastEditedOn()->shouldBe(null);
        $this->edit($description)->shouldBe($this->getWrappedObject());

        $this->description()->shouldBe($description);
        $this->lastEditedOn()->shouldBeAnInstanceOf(\DateTimeImmutable::class);
        $this->releaseEvents()[0]->shouldBeAnInstanceOf(AnswerWasEdited::class);
    }

    function it_can_be_voted()
    {
        $this->isVoted()->shouldBe(false);
    }

    function it_has_positive_votes()
    {
        $this->positiveVotes()->shouldBe($this->positiveVotes);
    }

    function it_has_negative_votes()
    {
        $this->negativeVotes()->shouldBe($this->negativeVotes);
    }

    /**
     * @throws \Exception
     */
    function it_can_add_a_positive_vote()
    {
        $this->releaseEvents();
        $this->addVote(Vote::positive())->shouldBe($this->getWrappedObject());
        $this->positiveVotes()->shouldBe(1);
        $this->negativeVotes()->shouldBe(0);
        $this->releaseEvents()[0]->shouldBeAnInstanceOf(AnswerWasVoted::class);
    }

    /**
     * @throws \Exception
     */
    function it_can_add_a_negative_vote()
    {
        $this->releaseEvents();
        $this->addVote(Vote::negative())->shouldBe($this->getWrappedObject());
        $this->positiveVotes()->shouldBe(0);
        $this->negativeVotes()->shouldBe(1);
        $this->releaseEvents()[0]->shouldBeAnInstanceOf(AnswerWasVoted::class);
    }

}

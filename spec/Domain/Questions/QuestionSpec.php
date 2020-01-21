<?php

namespace spec\App\Domain\Questions;

use App\Domain\Answers\Answer;
use App\Domain\Answers\Answer\AnswerId;
use App\Domain\Events\EventGenerator;
use App\Domain\Questions\Events\QuestionWasCreated;
use App\Domain\Questions\Events\QuestionWasEdited;
use App\Domain\Questions\Events\TagsWereUpdated;
use App\Domain\Questions\Question;
use App\Domain\Questions\Tag;
use App\Domain\UserManagement\User\UserId;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use PhpSpec\ObjectBehavior;

class QuestionSpec extends ObjectBehavior
{

    private $userId;
    private $question;
    private $description;

    function let()
    {
        $this->userId = new UserId();
        $this->question = 'What?';
        $this->description = 'Else...';
        $this->beConstructedWith($this->userId, $this->question, $this->description);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Question::class);
    }

    function its_an_event_generator()
    {
        $this->shouldBeAnInstanceOf(EventGenerator::class);
        $this->releaseEvents()[0]->shouldBeAnInstanceOf(QuestionWasCreated::class);
    }

    function it_has_a_question_id()
    {
        $this->questionId()->shouldBeAnInstanceOf(Question\QuestionId::class);
    }

    function it_has_a_user_id()
    {
        $this->userId()->shouldBe($this->userId);
    }

    function it_has_a_question()
    {
        $this->question()->shouldBe($this->question);
    }

    function it_has_a_description()
    {
        $this->description()->shouldBe($this->description);
    }

    function it_has_an_applied_date_time()
    {
        $this->appliedOn()->shouldBeAnInstanceOf(\DateTimeImmutable::class);
    }

    function it_has_an_open_state()
    {
        $this->isOpen()->shouldBe(true);
    }

    function it_can_be_edited()
    {
        $this->releaseEvents();
        $question = 'New question?';
        $description = 'new description';
        $this->lastEditedOn()->shouldBe(null);
        $this->edit($question, $description)->shouldBe($this->getWrappedObject());

        $this->question()->shouldBe($question);
        $this->description()->shouldBe($description);
        $this->lastEditedOn()->shouldBeAnInstanceOf(\DateTimeImmutable::class);
        $this->releaseEvents()[0]->shouldBeAnInstanceOf(QuestionWasEdited::class);
    }

    function it_can_update_its_tags()
    {
        $this->releaseEvents();
        $this->tags()->shouldBeAnInstanceOf(Collection::class);
        $collection = new ArrayCollection([
            new Tag('test1'),
            new Tag('test2')
        ]);
        $this->updateTags($collection)->shouldBe($this->getWrappedObject());

        $this->tags()->shouldBe($collection);
        $this->releaseEvents()[0]->shouldBeAnInstanceOf(TagsWereUpdated::class);
    }

    function it_has_a_list_of_answers(Answer $answer)
    {
        $answerId = new AnswerId();
        $answer->answerId()->willReturn($answerId);

        $answers = $this->listOfAnswers();
        $answers->shouldBeArray();
        $answers->shouldHaveCount(0);

        $this->addAnswer($answer)->shouldBe($this->getWrappedObject());

        $answers = $this->listOfAnswers();
        $answers->shouldBeArray();
        $answers->shouldHaveCount(1);

        $answers[(string) $answerId]->shouldBe($answer);
    }

    function it_can_have_an_accepted_answer(Answer $answer1, Answer $answer2)
    {
        $this->acceptedAnswer()->shouldBeNull();

        $answerId1 = new AnswerId();
        $answer1->answerId()->willReturn($answerId1);
        $answer1->isAccepted()->willReturn(true);

        $answerId2 = new AnswerId();
        $answer2->answerId()->willReturn($answerId2);
        $answer2->isAccepted()->willReturn(false);

        $this->addAnswer($answer1)->addAnswer($answer2);

        $this->acceptedAnswer()->shouldBe($answer1);
    }

    function it_can_remove_an_answer(Answer $answer1, Answer $answer2)
    {
        $answerId1 = new AnswerId();
        $answer1->answerId()->willReturn($answerId1);

        $answerId2 = new AnswerId();
        $answer2->answerId()->willReturn($answerId2);

        $this->addAnswer($answer1)->addAnswer($answer2);

        $answers = $this->listOfAnswers();
        $answers->shouldHaveCount(2);
        $answers[(string) $answerId1]->shouldBe($answer1);

        $this->removeAnswer($answer2)->shouldBe($this->getWrappedObject());

        $answers = $this->listOfAnswers();
        $answers->shouldHaveCount(1);
        $answers[(string) $answerId1]->shouldBe($answer1);
    }

    public function it_can_be_converted_to_json()
    {
        $this->shouldBeAnInstanceOf(\JsonSerializable::class);
        $this->jsonSerialize()->shouldBe([
            'questionId' => $this->questionId(),
            'userId' => $this->userId(),
            'question' => $this->question,
            'description' => $this->description,
            'appliedOn' => $this->appliedOn(),
            'open' => $this->isOpen(),
            'lastEditedOn' => $this->lastEditedOn(),
            'tags' => $this->tags(),
            'listOfAnswers' => $this->listOfAnswers(),
            'acceptedAnswer' => $this->acceptedAnswer()
        ]);
    }
}

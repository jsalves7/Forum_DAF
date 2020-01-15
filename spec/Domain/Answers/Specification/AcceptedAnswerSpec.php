<?php

namespace spec\App\Domain\Answers\Specification;

use App\Domain\Answers\Answer;
use App\Domain\Answers\AnswerSpecification;
use App\Domain\Answers\Specification\AcceptedAnswer;
use PhpSpec\ObjectBehavior;

class AcceptedAnswerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(AcceptedAnswer::class);
    }

    function its_an_answer_specification()
    {
        $this->shouldBeAnInstanceOf(AnswerSpecification::class);
    }

    function it_validates_answer_when_flag_accepted_is_false(Answer $answer)
    {
        $answer->isAccepted()->shouldBeCalled()->willReturn(true);
        $this->isSatisfiedBy($answer)->shouldBe(true);

        $answer->isAccepted()->willReturn(false);
        $this->isSatisfiedBy($answer)->shouldBe(false);
    }

}

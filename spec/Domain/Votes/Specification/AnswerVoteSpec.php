<?php

namespace spec\App\Domain\Votes\Specification;

use App\Domain\Answers\Answer;
use App\Domain\Votes\Specification\AnswerVote;
use App\Domain\Votes\VoteSpecification;
use PhpSpec\ObjectBehavior;

class AnswerVoteSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(AnswerVote::class);
    }

    function its_a_vote_specification()
    {
        $this->shouldBeAnInstanceOf(VoteSpecification::class);
    }

    function it_validates_vote_when_flag_voted_is_false(Answer $answer)
    {
        $answer->isVoted()->shouldBeCalled()->willReturn(true);
        $this->isSatisfiedBy($answer)->shouldBe(true);

        $answer->isVoted()->willReturn(false);
        $this->isSatisfiedBy($answer)->shouldBe(false);
    }

}

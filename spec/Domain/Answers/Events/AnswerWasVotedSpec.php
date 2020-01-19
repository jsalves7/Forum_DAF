<?php

namespace spec\App\Domain\Answers\Events;

use App\Domain\Answers\Answer\AnswerId;
use App\Domain\Answers\Events\AnswerWasVoted;
use App\Domain\Votes\Vote;
use PhpSpec\ObjectBehavior;

class AnswerWasVotedSpec extends ObjectBehavior
{

    private $answerId;
    private $vote;

    function let()
    {
        $this->answerId = new AnswerId();
        $this->vote = Vote::negative();
        $this->beConstructedWith($this->answerId, $this->vote);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AnswerWasVoted::class);
    }

    function it_has_an_answer_id()
    {
        $this->answerId()->shouldBe($this->answerId);
    }

    function it_has_a_vote()
    {
        $this->vote()->shouldBe($this->vote);
    }
}

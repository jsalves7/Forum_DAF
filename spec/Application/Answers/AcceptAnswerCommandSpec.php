<?php

namespace spec\App\Application\Answers;

use App\Application\Answers\AcceptAnswerCommand;
use App\Domain\Answers\Answer\AnswerId;
use PhpSpec\ObjectBehavior;

class AcceptAnswerCommandSpec extends ObjectBehavior
{

    private $answerId;

    function let()
    {
        $this->answerId = new AnswerId();
        $this->beConstructedWith($this->answerId);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AcceptAnswerCommand::class);
    }

    function it_has_an_answer_id()
    {
        $this->answerId()->shouldBe($this->answerId);
    }
}

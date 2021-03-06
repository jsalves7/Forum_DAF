<?php

namespace spec\App\Application\Answers;

use App\Application\Answers\DeleteAnswerCommand;
use App\Domain\Answers\Answer\AnswerId;
use PhpSpec\ObjectBehavior;

class DeleteAnswerCommandSpec extends ObjectBehavior
{

    private $answerId;

    function let()
    {
        $this->answerId = new AnswerId();
        $this->beConstructedWith($this->answerId);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DeleteAnswerCommand::class);
    }

    function it_has_an_answer_id()
    {
        $this->answerId()->shouldBe($this->answerId);
    }
}

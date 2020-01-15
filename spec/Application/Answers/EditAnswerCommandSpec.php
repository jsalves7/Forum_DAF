<?php

namespace spec\App\Application\Answers;

use App\Application\Answers\EditAnswerCommand;
use App\Domain\Answers\Answer\AnswerId;
use PhpSpec\ObjectBehavior;

class EditAnswerCommandSpec extends ObjectBehavior
{

    private $answerId;
    private $description;

    function let()
    {
        $this->answerId = new AnswerId();
        $this->description = "Another possible solution";
        $this->beConstructedWith($this->answerId, $this->description);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(EditAnswerCommand::class);
    }

    function it_has_an_answer_id()
    {
        $this->answerId()->shouldBe($this->answerId);
    }

    function it_has_a_description()
    {
        $this->description()->shouldBe($this->description);
    }
}

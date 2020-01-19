<?php

namespace spec\App\Domain\Answers\Events;

use App\Domain\Answers\Answer\AnswerId;
use App\Domain\Answers\Events\AnswerWasAccepted;
use App\Domain\Events\AbstractDomainEvent;
use App\Domain\Events\DomainEvent;
use DateTimeImmutable;
use PhpSpec\ObjectBehavior;

class AnswerWasAcceptedSpec extends ObjectBehavior
{

    private $answerId;

    function let()
    {
        $this->answerId = new AnswerId();
        $this->beConstructedWith($this->answerId);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AnswerWasAccepted::class);
    }

    function its_a_domain_event()
    {
        $this->shouldBeAnInstanceOf(DomainEvent::class);
        $this->shouldHaveType(AbstractDomainEvent::class);
        $this->occurredOn()->shouldBeAnInstanceOf(DateTimeImmutable::class);
    }

    function it_has_an_answer_id()
    {
        $this->answerId()->shouldBe($this->answerId);
    }
}

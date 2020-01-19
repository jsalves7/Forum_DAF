<?php

namespace spec\App\Domain\Votes;

use App\Domain\Votes\Vote;
use PhpSpec\ObjectBehavior;

class VoteSpec extends ObjectBehavior
{

    private $vote;

    /**
     * @throws \Exception
     */
    function let()
    {
        $this->vote = true;
        $this->beConstructedThrough("positive", []);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Vote::class);
    }

    function it_can_check_if_its_positive()
    {
        $this->isPositive()->shouldBe(true);
    }

    function it_can_check_if_its_negative()
    {
        $this->isNegative()->shouldBe(false);
    }

    function it_can_be_created_through_factory_methods()
    {
        $this->beConstructedThrough('negative', []);
        $this->isNegative()->shouldBe(true);
        $this->isPositive()->shouldBe(false);
    }

    function it_can_be_converted_to_json()
    {
        $this->shouldBeAnInstanceOf(\JsonSerializable::class);
        $this->jsonSerialize()->shouldBe([
            "vote" => $this->vote,
        ]);
    }
}

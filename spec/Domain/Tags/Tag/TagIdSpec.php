<?php

namespace spec\App\Domain\Tags\Tag;

use App\Domain\Common\RootAggregatorId;
use App\Domain\Comparable;
use App\Domain\Stringable;
use App\Domain\Tags\Tag\TagId;
use PhpSpec\Exception\Example\FailureException;
use PhpSpec\ObjectBehavior;
use Ramsey\Uuid\Uuid;

class TagIdSpec extends ObjectBehavior
{

    function it_is_initializable()
    {
        $this->shouldHaveType(TagId::class);
    }

    function it_is_an_aggregator()
    {
        $this->shouldBeAnInstanceOf(RootAggregatorId::class);
    }

    /**
     * @throws FailureException
     */
    function it_can_be_treated_has_a_string()
    {
        $this->shouldBeAnInstanceOf(Stringable::class);
        $result = $this->__toString();
        if (!Uuid::isValid($result->getWrappedObject())) {
            throw new FailureException(
                "UUID string its not valid!"
            );
        }
    }

    /**
     * @throws \Exception
     */
    function it_can_be_compared_to_other_objects()
    {
        $other = new TagId($this->__toString()->getWrappedObject());
        $this->shouldBeAnInstanceOf(Comparable::class);
        $this->equalsTo($other)->shouldBe(true);
    }

    /**
     * @throws \Exception
     */
    function it_can_be_converted_to_json()
    {
        $uuid = Uuid::uuid4()->toString();
        $this->beConstructedWith($uuid);
        $this->shouldBeAnInstanceOf(\JsonSerializable::class);
        $this->jsonSerialize()->shouldBe($uuid);
    }

    /**
     * @throws \Exception
     */
    function it_can_be_created_from_an_existing_string()
    {
        $uuidTxt = Uuid::uuid4()->toString();
        $this->beConstructedWith($uuidTxt);
        $this->shouldHaveType(TagId::class);
        $this->jsonSerialize()->shouldBe($uuidTxt);
    }
}

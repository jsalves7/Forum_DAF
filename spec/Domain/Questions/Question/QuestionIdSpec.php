<?php

namespace spec\App\Domain\Questions\Question;

use App\Domain\Common\RootAggregatorId;
use App\Domain\Comparable;
use App\Domain\Questions\Question\QuestionId;
use App\Domain\Stringable;
use PhpSpec\Exception\Example\FailureException;
use PhpSpec\ObjectBehavior;
use Ramsey\Uuid\Uuid;

class QuestionIdSpec extends ObjectBehavior
{

    function it_is_initializable()
    {
        $this->shouldHaveType(QuestionId::class);
    }

    function its_an_aggregator()
    {
        $this->shouldBeAnInstanceOf(RootAggregatorId::class);
    }

    /**
     * @throws FailureException
     */
    function it_can_be_treated_as_a_string()
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
        $other = new QuestionId($this->__toString()->getWrappedObject());
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
        $this->shouldHaveType(QuestionId::class);
        $this->jsonSerialize()->shouldBe($uuidTxt);
    }

}

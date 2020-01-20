<?php

namespace spec\App\Domain\Questions;

use App\Domain\Questions\Tag;
use App\Domain\Stringable;
use PhpSpec\ObjectBehavior;

class TagSpec extends ObjectBehavior
{

    private $description;

    function let()
    {
        $this->description = 'php';
        $this->beConstructedWith($this->description);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Tag::class);
    }

    function it_has_a_tag_id()
    {
        $this->tagId()->shouldBeAnInstanceOf(Tag\TagId::class);
    }

    function it_has_a_description()
    {
        $this->description()->shouldBe($this->description);
    }

    function it_can_be_treated_as_a_string()
    {
        $this->shouldBeAnInstanceOf(Stringable::class);
        $this->__toString()->shouldBe($this->description);
    }

    function it_can_be_converted_to_json()
    {
        $this->shouldBeAnInstanceOf(\JsonSerializable::class);
        $this->jsonSerialize()->shouldBe([
            'tagId' => $this->tagId(),
            'description' => $this->description
        ]);
    }
}

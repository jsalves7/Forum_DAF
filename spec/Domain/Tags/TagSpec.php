<?php

namespace spec\App\Domain\Tags;

use App\Domain\Tags\Tag;
use App\Domain\Tags\Tag\TagId;
use PhpSpec\ObjectBehavior;

class TagSpec extends ObjectBehavior
{

    private $description;

    function let()
    {
        $this->description = "tag";
        $this->beConstructedWith($this->description);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Tag::class);
    }

    function it_has_a_tag_id()
    {
        $this->tagId()->shouldBeAnInstanceOf(TagId::class);
    }

    function it_has_a_description()
    {
        $this->description()->shouldBe($this->description);
    }

    function it_can_be_converted_to_json()
    {
        $this->shouldBeAnInstanceOf(\JsonSerializable::class);
        $this->jsonSerialize()->shouldBe([
            'tagId' => $this->tagId(),
            'description' => $this->description,
        ]);
    }
}

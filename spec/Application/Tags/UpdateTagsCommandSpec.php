<?php

namespace spec\App\Application\Tags;

use App\Domain\Questions\Question\QuestionId;
use App\Application\Tags\UpdateTagsCommand;
use PhpSpec\ObjectBehavior;

class UpdateTagsCommandSpec extends ObjectBehavior
{

    private $questionId;
    private $tags;

    function let()
    {
        $this->questionId = new QuestionId();
        $this->tags = ['tag1', 'tag2'];
        $this->beConstructedWith($this->questionId, $this->tags);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UpdateTagsCommand::class);
    }

    function it_has_a_question_id()
    {
        $this->questionId()->shouldBe($this->questionId);
    }

    function it_has_a_list_of_tags()
    {
        $this->tags()->shouldBe($this->tags);
    }
}

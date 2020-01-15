<?php

namespace spec\App\Application\Tags;

use App\Application\Tags\UpdateTagsCommandHandler;
use PhpSpec\ObjectBehavior;

class UpdateTagsCommandHandlerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(UpdateTagsCommandHandler::class);
    }
}

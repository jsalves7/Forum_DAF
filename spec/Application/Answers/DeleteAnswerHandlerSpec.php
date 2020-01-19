<?php

namespace spec\App\Application\Answers;

use App\Application\Answers\DeleteAnswerHandler;
use PhpSpec\ObjectBehavior;

class DeleteAnswerHandlerSpec extends ObjectBehavior
{



    function it_is_initializable()
    {
        $this->shouldHaveType(DeleteAnswerHandler::class);
    }
}

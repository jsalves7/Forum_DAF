<?php

namespace spec\App\Application\Answers;

use App\Application\Answers\AddAnswerCommand;
use App\Application\Answers\AddAnswerHandler;
use App\Domain\Answers\Answer;
use App\Domain\Answers\AnswersRepository;
use App\Domain\Questions\Question\QuestionId;
use App\Domain\UserManagement\User\UserId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AddAnswerHandlerSpec extends ObjectBehavior
{

    private $questionId;
    private $userId;
    private $description;

    function let(AnswersRepository $repository)
    {
        $this->questionId = new QuestionId();
        $this->userId = new UserId();
        $this->description = "Possible Solution";

        $repository->add(Argument::type(Answer::class))->willReturnArgument(0);

        $this->beConstructedWith($repository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AddAnswerHandler::class);
    }

    function it_handles_add_answer_command(AnswersRepository $repository)
    {
        $command = new AddAnswerCommand($this->questionId, $this->userId, $this->description);
        $answer = $this->handle($command);
        $answer->shouldBeAnInstanceOf(Answer::class);

        $repository->add($answer)->shouldHaveBeenCalled();
    }
}

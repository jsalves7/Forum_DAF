<?php

namespace spec\App\Application\Questions;

use App\Application\Questions\DeleteQuestionCommand;
use App\Application\Questions\DeleteQuestionHandler;
use App\Domain\Events\EventPublisher;
use App\Domain\Exceptions\InvalidQuestionOwner;
use App\Domain\Questions\Events\QuestionWasDeleted;
use App\Domain\Questions\Question;
use App\Domain\Questions\Question\QuestionId;
use App\Domain\Questions\QuestionsRepository;
use App\Domain\Questions\Specification\QuestionOwner;
use PhpSpec\ObjectBehavior;

class DeleteQuestionHandlerSpec extends ObjectBehavior
{

    private $questionId;

    function let(
        QuestionsRepository $questions,
        Question $question,
        QuestionOwner $questionOwner,
        EventPublisher $eventPublisher
    ) {
        $this->questionId = new QuestionId();
        $questions->withId($this->questionId)->willReturn($question);

        $questionOwner->isSatisfiedBy($question)->willReturn(true);

        $this->beConstructedWith($questions, $questionOwner, $eventPublisher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DeleteQuestionHandler::class);
    }

    /**
     * @param QuestionsRepository|\PhpSpec\Wrapper\Collaborator $questions
     * @param Question|\PhpSpec\Wrapper\Collaborator $question
     * @param EventPublisher|\PhpSpec\Wrapper\Collaborator $eventPublisher
     * @throws \Exception
     */
    function it_handles_delete_question_command(
        QuestionsRepository $questions,
        Question $question
    ) {
        $command = new DeleteQuestionCommand(
            $this->questionId
        );

        $this->handle($command)->shouldBe($question);
        $questions->remove($question)->shouldHaveBeenCalled();
    }

    /**
     * @param QuestionOwner|\PhpSpec\Wrapper\Collaborator $questionOwner
     * @param Question|\PhpSpec\Wrapper\Collaborator $question
     */
    function it_throws_an_exception_when_user_is_not_the_owner(
        QuestionOwner $questionOwner,
        Question $question
    ) {
        $command = new DeleteQuestionCommand(
            $this->questionId
        );

        $questionOwner->isSatisfiedBy($question)->willReturn(false);
        $this->shouldThrow(InvalidQuestionOwner::class)
            ->during('handle', [$command]);
    }
}

<?php

namespace spec\App\Application\Answers;

use App\Application\Answers\EditAnswerCommand;
use App\Application\Answers\EditAnswerHandler;
use App\Domain\Answers\Answer;
use App\Domain\Answers\Answer\AnswerId;
use App\Domain\Answers\AnswersRepository;
use App\Domain\Answers\Specification\AcceptedAnswer;
use App\Domain\Answers\Specification\AnswerOwner;
use App\Domain\Events\EventPublisher;
use App\Domain\Exceptions\InvalidAnswerOwner;
use App\Domain\Exceptions\InvalidAnswerState;
use App\Domain\Questions\Question;
use App\Domain\Questions\Question\QuestionId;
use App\Domain\Questions\QuestionsRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EditAnswerHandlerSpec extends ObjectBehavior
{

    private $answerId;
    private $questionId;

    function let(
        AnswersRepository $answers,
        AnswerOwner $answerOwner,
        AcceptedAnswer $acceptedAnswer,
        QuestionsRepository $questions,
        EventPublisher $eventPublisher,
        Question $question,
        Answer $answer
    ) {

        $this->questionId = new QuestionId();
        $questions->withId($this->questionId)->willReturn($question);

        $this->answerId = new AnswerId();
        $answers->withId($this->answerId)->willReturn($answer);
        $answers->update($answer)->willReturn($answer);

        $answerOwner->isSatisfiedBy($answer)->willReturn(true);
        $acceptedAnswer->isSatisfiedBy($answer)->willReturn(true);

        $answer->edit(
            Argument::type('string')
        )
            ->willReturn($answer);

        $this->beConstructedWith($answers, $answerOwner, $acceptedAnswer, $eventPublisher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(EditAnswerHandler::class);
    }

    /**
     * @param Answer|\PhpSpec\Wrapper\Collaborator $answer
     * @param AnswersRepository|\PhpSpec\Wrapper\Collaborator $answers
     * @param EventPublisher|\PhpSpec\Wrapper\Collaborator $eventPublisher
     *
     * @throws \Exception
     */
    function it_handles_the_edit_answer_command(Answer $answer, AnswersRepository $answers, EventPublisher $eventPublisher)
    {
        $description = "A given description";
        $command = new EditAnswerCommand(
            $this->answerId,
            $description
        );
        $this->handle($command)->shouldBe($answer);
        $answer->edit($description)->shouldHaveBeenCalled();
        $answers->update($answer)->shouldHaveBeenCalled();
        $eventPublisher->publishEventsFrom($answer)->shouldHaveBeenCalled();
    }

    /**
     * @param AnswerOwner|\PhpSpec\Wrapper\Collaborator $answerOwner
     * @param Answer|\PhpSpec\Wrapper\Collaborator $answer
     */
    function it_throws_an_exception_when_user_is_not_the_owner(AnswerOwner $answerOwner, Answer $answer)
    {
        $description = "A given description";
        $command = new EditAnswerCommand(
            $this->answerId,
            $description
        );
        $answerOwner->isSatisfiedBy($answer)->willReturn(false);
        $this->shouldThrow(InvalidAnswerOwner::class)
            ->during('handle', [$command]);
    }

    /**
     * @param Answer|\PhpSpec\Wrapper\Collaborator $answer
     * @param AcceptedAnswer|\PhpSpec\Wrapper\Collaborator $acceptedAnswer
     */
    function it_throws_an_exception_when_answer_is_already_accepted(Answer $answer, AcceptedAnswer $acceptedAnswer)
    {
        $description = "A given description";
        $command = new EditAnswerCommand(
            $this->answerId,
            $description
        );
        $acceptedAnswer->isSatisfiedBy($answer)->willReturn(false);
        $this->shouldThrow(InvalidAnswerState::class)
            ->during('handle', [$command]);
    }
}

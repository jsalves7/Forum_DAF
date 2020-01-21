<?php

namespace spec\App\Application\Answers;

use App\Application\Answers\AcceptAnswerCommand;
use App\Application\Answers\AcceptAnswerHandler;
use App\Domain\Answers\Answer;
use App\Domain\Answers\Answer\AnswerId;
use App\Domain\Answers\AnswersRepository;
use App\Domain\Events\EventPublisher;
use App\Domain\Exceptions\InvalidQuestionOwner;
use App\Domain\Questions\Question;
use App\Domain\Questions\Question\QuestionId;
use App\Domain\Questions\QuestionsRepository;
use App\Domain\Questions\Specification\QuestionOwner;
use PhpSpec\ObjectBehavior;

class AcceptAnswerHandlerSpec extends ObjectBehavior
{

    private $answerId;
    private $questionId;

    function let(
        AnswersRepository $answers,
        QuestionsRepository $questions,
        QuestionOwner $questionOwner,
        EventPublisher $eventPublisher,
        Question $question,
        Answer $answer
    ) {
        $this->questionId = new QuestionId();
        $questions->withId($this->questionId)->willReturn($question);

        $this->answerId = new AnswerId();
        $answers->withId($this->answerId)->willReturn($answer);
        $answer->setAsAccepted()->willReturn($answer);
        $answers->update($answer)->willReturnArgument(0);
        $questionOwner->isSatisfiedBy($question)->willReturn(true);

        $this->beConstructedWith($answers, $questionOwner, $eventPublisher, $question);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AcceptAnswerHandler::class);
    }

    /**
     * @param Answer|\PhpSpec\Wrapper\Collaborator $answer
     * @param AnswersRepository|\PhpSpec\Wrapper\Collaborator $answers
     * @param EventPublisher|\PhpSpec\Wrapper\Collaborator $eventPublisher
     *
     * @throws \Exception
     */
    function it_handles_the_accept_answer_command(
        Answer $answer,
        AnswersRepository $answers,
        EventPublisher $eventPublisher
    ) {
        $command = new AcceptAnswerCommand(
            $this->answerId
        );

        $this->handle($command)->shouldBe($answer);
        $answer->setAsAccepted()->shouldHaveBeenCalled();
        $answers->update($answer)->shouldHaveBeenCalled();
        $eventPublisher->publishEventsFrom($answer)->shouldHaveBeenCalled();
    }

}

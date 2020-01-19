<?php

namespace spec\App\Application\Answers;

use App\Application\Answers\VoteAnswerCommand;
use App\Application\Answers\VoteAnswerHandler;
use App\Domain\Answers\Answer;
use App\Domain\Answers\Answer\AnswerId;
use App\Domain\Answers\AnswersRepository;
use App\Domain\Events\EventPublisher;
use App\Domain\Exceptions\InvalidUserVote;
use App\Domain\Questions\Question;
use App\Domain\Questions\Question\QuestionId;
use App\Domain\Questions\QuestionsRepository;
use App\Domain\Votes\Specification\UserVote;
use App\Domain\Votes\Vote;
use PhpSpec\ObjectBehavior;

class VoteAnswerHandlerSpec extends ObjectBehavior
{

    private $answerId;
    private $questionId;

    function let(
        AnswersRepository $answers,
        QuestionsRepository $questions,
        UserVote $userVote,
        EventPublisher $eventPublisher,
        Question $question,
        Answer $answer
    ) {
        $this->questionId = new QuestionId();
        $questions->withId($this->questionId)->willReturn($question);

        $this->answerId = new AnswerId();
        $answers->withId($this->answerId)->willReturn($answer);
        $answers->update($answer)->willReturn($answer);

        $userVote->isSatisfiedBy($answer)->willReturn(true);

        $this->beConstructedWith($answers, $questions, $userVote, $eventPublisher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(VoteAnswerHandler::class);
    }

    function it_handles_vote_answer_command(Answer $answer, AnswersRepository $answers, EventPublisher $eventPublisher)
    {
        $vote = Vote::positive();
        $command = new VoteAnswerCommand(
            $this->answerId,
            $vote
        );
        $answer->addVote($vote)->shouldBeCalled()->willReturn($answer);
        $this->handle($command)->shouldBe($answer);
        $answers->update($answer)->shouldBeCalled();

        $eventPublisher->publishEventsFrom($answer)->shouldHaveBeenCalled();
    }

    function it_throws_an_exception_when_user_already_voted(Answer $answer, UserVote $userVote)
    {
        $vote = Vote::positive();
        $command = new VoteAnswerCommand(
            $this->answerId,
            $vote
        );
        $userVote->isSatisfiedBy($answer)->willReturn(false);
        $this->shouldThrow(InvalidUserVote::class)
            ->during('handle', [$command]);
    }
}

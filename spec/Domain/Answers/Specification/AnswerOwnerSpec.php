<?php

namespace spec\App\Domain\Answers\Specification;

use App\Domain\Answers\Answer;
use App\Domain\Answers\AnswerSpecification;
use App\Domain\Answers\Specification\AnswerOwner;
use App\Domain\UserManagement\User;
use App\Domain\UserManagement\UserIdentifier;
use PhpSpec\ObjectBehavior;

class AnswerOwnerSpec extends ObjectBehavior
{

    private $userId;

    function let(UserIdentifier $identifier, User $loggedInUser)
    {
        $this->userId = new User\UserId();
        $loggedInUser->userId()->willReturn($this->userId);
        $identifier->currentUser()->willReturn($loggedInUser);
        $this->beConstructedWith($identifier);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AnswerOwner::class);
    }

    function its_an_answer_specification()
    {
        $this->shouldBeAnInstanceOf(AnswerSpecification::class);
    }

    function it_checks_true_when_owner_is_current_logged_in_user(Answer $answer)
    {
        $answer->userId()->willReturn($this->userId);
        $this->isSatisfiedBy($answer)->shouldBe(true);
    }

    function it_checks_false_when_owner_is_not_current_user(Answer $answer)
    {
        $answer->userId()->willReturn(new User\UserId());
        $this->isSatisfiedBy($answer)->shouldBe(false);
    }
}

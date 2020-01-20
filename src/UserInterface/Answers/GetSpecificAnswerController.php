<?php


namespace App\UserInterface\Answers;


use App\Domain\Answers\Answer\AnswerId;
use App\Domain\Answers\AnswersRepository;
use App\Domain\Exceptions\AnswerNotFound;
use App\Domain\UserManagement\User;
use App\UserInterface\ApiControllerMethods;
use App\UserInterface\UserManagement\OAuth2\AuthenticatedControllerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetSpecificAnswerController extends AbstractController implements AuthenticatedControllerInterface
{
    use ApiControllerMethods;

    /**
     * @var AnswersRepository
     */
    private $answers;

    /**
     * @var User
     */
    private $user;

    /**
     * Creates a GetSpecificAnswerController
     *
     * @param AnswersRepository $answers
     */
    public function __construct(AnswersRepository $answers)
    {
        $this->answers = $answers;
    }

    /**
     * @param $answerId
     * @return Response
     *
     * @Route("/answers/{answerId}", methods={"GET"})
     */
    public function handle($answerId)
    {
        try {
            $answerId = new AnswerId($answerId);
            $answer = $this->answers->withId($answerId);
        } catch (AnswerNotFound $exception) {
            return $this->badRequest($exception->getMessage(), Response::HTTP_NOT_FOUND);
        }

        return $this->response($answer);
    }

    /**
     * @inheritDoc
     */
    public function currentUser(): User
    {
        return $this->user;
    }

    /**
     * @inheritDoc
     */
    public function withCurrentUser(User $user): AuthenticatedControllerInterface
    {
        $this->user = $user;
        return $this;
    }
}
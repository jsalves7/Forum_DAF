<?php


namespace App\UserInterface\Questions;


use App\Domain\Exceptions\QuestionNotFound;
use App\Domain\Questions\Question\QuestionId;
use App\Domain\Questions\QuestionsRepository;
use App\Domain\UserManagement\User;
use App\UserInterface\ApiControllerMethods;
use App\UserInterface\UserManagement\OAuth2\AuthenticatedControllerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetSpecificQuestionController extends AbstractController implements AuthenticatedControllerInterface
{
    use ApiControllerMethods;

    /**
     * @var QuestionsRepository
     */
    private $questions;

    /**
     * @var User
     */
    private $user;

    /**
     * Creates a GetSpecificAnswerController
     *
     * @param QuestionsRepository $questions
     */
    public function __construct(QuestionsRepository $questions)
    {
        $this->questions = $questions;
    }

    /**
     * @param $questionId
     *
     * @return Response
     * @throws \Exception
     *
     * @Route("/questions/{questionId}", methods={"GET"})
     */
    public function handle($questionId)
    {
        try {
            $questionId = new QuestionId($questionId);
            $question = $this->questions->withId($questionId);
        } catch (QuestionNotFound $exception) {
            return $this->badRequest($exception->getMessage(), Response::HTTP_NOT_FOUND);
        }

        return $this->response($question);
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
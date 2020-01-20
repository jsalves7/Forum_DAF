<?php


namespace App\UserInterface\Questions;


use App\Application\Questions\EditQuestionCommand;
use App\Domain\Exceptions\QuestionNotFound;
use App\Domain\Exceptions\SpecificationFailure;
use App\Domain\Questions\Question\QuestionId;
use App\Domain\UserManagement\User;
use App\UserInterface\ApiControllerMethods;
use App\UserInterface\UserManagement\OAuth2\AuthenticatedControllerInterface;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UpdateQuestionController extends AbstractController implements AuthenticatedControllerInterface
{
    use ApiControllerMethods;

    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @var User
     */
    private $user;

    /**
     * Creates a UpdateQuestionController
     *
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @param Request $request
     * @param $questionId
     *
     * @return Response
     * @throws \Exception
     *
     * @Route("/questions/{questionId}", methods={"PATCH"})
     */
    public function handle(Request $request, $questionId)
    {
        $data = $this->parseRequest($request, ['question', 'description']);

        if (!$this->valid) {
            return $this->badRequest('Please check your question data.');
        }

        try {
            $questionId = new QuestionId($questionId);
            $command = new EditQuestionCommand(
                $questionId,
                $data->question,
                $data->description
            );
            $question = $this->commandBus->handle($command);
        } catch (QuestionNotFound $exception) {
            return $this->badRequest($exception->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (SpecificationFailure $exception) {
            return $this->badRequest($exception->getMessage(), Response::HTTP_CONFLICT);
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
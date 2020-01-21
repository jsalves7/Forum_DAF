<?php


namespace App\UserInterface\Answers;


use App\Application\Answers\AddAnswerCommand;
use App\Domain\Exceptions\QuestionNotFound;
use App\Domain\Questions\Question\QuestionId;
use App\Domain\UserManagement\User;
use App\UserInterface\ApiControllerMethods;
use App\UserInterface\UserManagement\OAuth2\AuthenticatedControllerInterface;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateAnswerController extends AbstractController implements AuthenticatedControllerInterface
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
     * Creates a CreateAnswerController
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
     * @return Response
     *
     * @Route("questions/{questionId}/answers", methods={"POST"})
     */
    public function handle(Request $request, $questionId)
    {
        $data = $this->parseRequest($request, ['description']);

        if (!$this->valid) {
            return $this->badRequest('Please check your answer data.');
        }

        try {
            $questionId = new QuestionId($questionId);
            $command = new AddAnswerCommand(
                $questionId,
                $this->currentUser()->userId(),
                $data->description
            );
            $answer = $this->commandBus->handle($command);
        } catch (QuestionNotFound $exception) {
            return $this->badRequest($exception->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (\Throwable $throwable) {
            return $this->badRequest($throwable->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
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

/**
 * @OA\Post(
 *     path="/questions/{questionId}/answers",
 *     operationId="addAnswer",
 *     summary="Adds a new answer",
 *     tags={"Answers"},
 *     requestBody={"$ref": "#/components/requestBodies/AddAnswer"},
 *     @OA\Response(
 *         response=200,
 *         description="The newlly crated answer",
 *         @OA\JsonContent(ref="#/components/schemas/Answer")
 *     ),
 *     security={
 *         {"OAuth2.0-Token": {}}
 *     },
 * )
 */
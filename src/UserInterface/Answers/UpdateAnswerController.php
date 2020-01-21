<?php


namespace App\UserInterface\Answers;


use App\Application\Answers\EditAnswerCommand;
use App\Domain\Answers\Answer\AnswerId;
use App\Domain\Exceptions\AnswerNotFound;
use App\Domain\Exceptions\SpecificationFailure;
use App\Domain\UserManagement\User;
use App\UserInterface\ApiControllerMethods;
use App\UserInterface\UserManagement\OAuth2\AuthenticatedControllerInterface;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UpdateAnswerController extends AbstractController implements AuthenticatedControllerInterface
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
     * Creates a UpdateAnswerController
     *
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @param Request $request
     * @param $answerId
     * @return Response
     *
     * @Route("/answers/{answerId}", methods={"PATCH"})
     */
    public function handle(Request $request, $answerId)
    {
        $data = $this->parseRequest($request, ['description']);

        if (!$this->valid) {
            return $this->badRequest('Please check your answer data.');
        }

        try {
            $answerId = new AnswerId($answerId);
            $command = new EditAnswerCommand(
                $answerId,
                $data->description
            );
            $answer = $this->commandBus->handle($command);
        } catch (AnswerNotFound $exception) {
            return $this->badRequest($exception->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (SpecificationFailure $exception) {
            return $this->badRequest($exception->getMessage(), Response::HTTP_CONFLICT);
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
 * @OA\Patch(
 *     path="/answers/{answerId}",
 *     operationId="UpdateAnswer",
 *     summary="Update an answer",
 *     tags={"Answers"},
 *     requestBody={"$ref": "#/components/requestBodies/UpdateAnswer"},
 *     @OA\Response(
 *         response=200,
 *         description="The updated answer",
 *         @OA\JsonContent(ref="#/components/schemas/UpdateAnswer")
 *     ),
 *     security={
 *         {"OAuth2.0-Token": {}}
 *     },
 * )
 */
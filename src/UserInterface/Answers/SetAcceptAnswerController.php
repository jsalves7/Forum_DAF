<?php


namespace App\UserInterface\Answers;


use App\Application\Answers\AcceptAnswerCommand;
use App\Domain\Answers\Answer\AnswerId;
use App\Domain\Exceptions\AnswerNotFound;
use App\Domain\Exceptions\SpecificationFailure;
use App\Domain\UserManagement\User;
use App\UserInterface\ApiControllerMethods;
use App\UserInterface\UserManagement\OAuth2\AuthenticatedControllerInterface;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SetAcceptAnswerController extends AbstractController implements AuthenticatedControllerInterface
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
     * Creates a SetAcceptAnswerController
     *
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @param $answerId
     * @return Response
     *
     * @Route("/answers/{answerId}/set-as-accepted", methods={"PATCH", "POST"})
     */
    public function handle($answerId)
    {
        try {
            $answerId = new AnswerId($answerId);
            $command = new AcceptAnswerCommand(
                $answerId
            );
            $answer = $this->commandBus->handle($command);
        } catch (SpecificationFailure $exception) {
            return $this->badRequest($exception->getMessage(), Response::HTTP_CONFLICT);
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

/**
 * @OA\Patch(
 *     path="/answers/{answerId}/set-as-accepted",
 *     tags={"Answers"},
 *     summary="Mark an answer as the accepted one",
 *     description="Marks the answer as the accepted one for its question",
 *     operationId="AcceptAnswer",
 *     @OA\Parameter(
 *         name="answerId",
 *         in="path",
 *         description="id of answer to mark as correct",
 *         required=true,
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="The updated answer",
 *         @OA\JsonContent(ref="#/components/schemas/Answer")
 *     ),
 *     security={
 *         {"OAuth2.0-Token": {}}
 *     },
 * )
 */


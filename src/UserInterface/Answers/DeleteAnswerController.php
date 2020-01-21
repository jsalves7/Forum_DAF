<?php


namespace App\UserInterface\Answers;


use App\Application\Answers\DeleteAnswerCommand;
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

class DeleteAnswerController extends AbstractController implements AuthenticatedControllerInterface
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
     * Creates a DeleteAnswerController
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
     * @Route("/answers/{answerId}", methods={"DELETE"})
     */
    public function handle($answerId)
    {
        try {
            $answerId = new AnswerId($answerId);
            $command = new DeleteAnswerCommand(
                $answerId
            );
            $this->commandBus->handle($command);
        } catch (AnswerNotFound $exception) {
            return $this->badRequest($exception->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (SpecificationFailure $exception) {
            return $this->badRequest($exception->getMessage(), Response::HTTP_CONFLICT);
        }

        return new Response("", Response::HTTP_NO_CONTENT);
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
 * @OA\Delete(
 *     path="/answers/{answerId}",
 *     tags={"Answers"},
 *     summary="Deletes an answer",
 *     description="Delete the answer that matches the provided answer ID",
 *     operationId="DeleteAnswer",
 *     @OA\Parameter(
 *         name="answerId",
 *         in="path",
 *         description="id of answer to delete",
 *         required=true,
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="The answer was deleted",
 *     ),
 *     security={
 *         {"OAuth2.0-Token": {}}
 *     },
 * )
 */
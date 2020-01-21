<?php


namespace App\UserInterface\Questions;


use App\Application\Questions\DeleteQuestionCommand;
use App\Domain\Exceptions\QuestionNotFound;
use App\Domain\Exceptions\SpecificationFailure;
use App\Domain\Questions\Question\QuestionId;
use App\Domain\UserManagement\User;
use App\UserInterface\ApiControllerMethods;
use App\UserInterface\UserManagement\OAuth2\AuthenticatedControllerInterface;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteQuestionController extends AbstractController implements AuthenticatedControllerInterface
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
     * Creates a DeleteQuestionController
     *
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @param $questionId
     *
     * @return Response
     * @throws \Exception
     *
     * @Route("/questions/{questionId}", methods={"DELETE"})
     */
    public function handle($questionId)
    {
        try {
            $questionId = new QuestionId($questionId);
            $command = new DeleteQuestionCommand(
                $questionId
            );
            $this->commandBus->handle($command);
        } catch (QuestionNotFound $exception) {
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
 *     path="/questions/{questionId}",
 *     tags={"Questions"},
 *     summary="Delete a question",
 *     description="Delete the question that matches the provided answer ID",
 *     operationId="DeleteQuestion",
 *     @OA\Parameter(
 *         name="questionId",
 *         in="path",
 *         description="id of question to delete",
 *         required=true,
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="Question was deleted"
 *     ),
 *     security={
 *         {"OAuth2.0-Token": {}}
 *     },
 * )
 *
 */
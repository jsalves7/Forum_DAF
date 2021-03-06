<?php


namespace App\UserInterface\Answers;



use App\Application\Answers\VoteAnswerCommand;
use App\Domain\Answers\Answer\AnswerId;
use App\Domain\Exceptions\AnswerNotFound;
use App\Domain\Exceptions\SpecificationFailure;
use App\Domain\UserManagement\User;
use App\Domain\Votes\Vote;
use App\UserInterface\ApiControllerMethods;
use App\UserInterface\UserManagement\OAuth2\AuthenticatedControllerInterface;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VoteAnswerController extends AbstractController implements AuthenticatedControllerInterface
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
     * Creates a VoteAnswerController
     *
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function handle(Vote $vote, $answerId)
    {
        try {
            $answerId = new AnswerId($answerId);
            $command = new VoteAnswerCommand(
                $answerId,
                $vote
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
     * @param $answerId
     * @return Response
     *
     * @Route("/answers/{answerId}/vote-positive", methods={"PUT"})
     */
    public function votePositive($answerId)
    {
        $vote = Vote::positive();

        return $this->handle($vote, $answerId);
    }

    /**
     * @param $answerId
     * @return Response
     *
     * @Route("/answers/{answerId}/vote-negative", methods={"PUT"})
     */
    public function voteNegative($answerId)
    {
        $vote = Vote::negative();

        return $this->handle($vote, $answerId);
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
 * @OA\Put(
 *     path="/answers/{answerId}/vote-positive",
 *     tags={"Answers"},
 *     summary="Vote positive an answer",
 *     description="Adds a positive vote to the answer that matches the provided answer id",
 *     operationId="votePositiveAnswer",
 *     @OA\Parameter(
 *         name="answerId",
 *         in="path",
 *         description="id of answer to vote",
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

/**
 * @OA\Put(
 *     path="/answers/{answerId}/vote-negative",
 *     tags={"Answers"},
 *     summary="Vote negative an answer",
 *     description="Adds a negative vote to the answer that matches the provided answer id",
 *     operationId="voteNegativeAnswer",
 *     @OA\Parameter(
 *         name="answerId",
 *         in="path",
 *         description="id of answer to vote",
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

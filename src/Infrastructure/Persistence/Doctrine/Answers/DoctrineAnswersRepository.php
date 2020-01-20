<?php


namespace App\Infrastructure\Persistence\Doctrine\Answers;


use App\Domain\Answers\Answer;
use App\Domain\Answers\Answer\AnswerId;
use App\Domain\Answers\AnswersRepository;
use App\Domain\Exceptions\AnswerNotFound;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException as ORMException;


class DoctrineAnswersRepository implements AnswersRepository
{
    /**
     * @var EntityManager|EntityManagerInterface
     */
    private $entityManager;

    /**
     * Creates a DoctrineAnswersRepository
     *
     * @param EntityManager|EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Adds an answer to the questions repository
     *
     * @param Answer $answer
     * @return Answer
     *
     * @throws ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function add(Answer $answer): Answer
    {
        $this->entityManager->persist($answer);
        $this->entityManager->flush();
        return $answer;
    }

    /**
     * @param AnswerId $answerId
     * @return Answer
     *
     * @throws ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     * @throws AnswerNotFound if no answer was found with the provided ID
     */
    public function withId(AnswerId $answerId): Answer
    {
        $answer = $this->entityManager->find(Answer::class, $answerId);

        if (!$answer instanceof Answer) {
            throw new AnswerNotFound("Answer not found!");
        }

        return $answer;
    }

    /**
     * Persists answer changes
     *
     * @param Answer $answer
     * @return Answer
     *
     * @throws ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update(Answer $answer): Answer
    {
        $this->entityManager->flush($answer);
        return $answer;
    }

    /**
     * Removes an answer from the answers repository
     *
     * @param Answer $answer
     * @throws ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function remove(Answer $answer): void
    {
        $this->entityManager->remove($answer);
        $this->entityManager->flush();
    }
}
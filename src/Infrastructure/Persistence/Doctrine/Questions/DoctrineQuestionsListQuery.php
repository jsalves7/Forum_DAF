<?php


namespace App\Infrastructure\Persistence\Doctrine\Questions;


use App\Application\QueryResult;
use App\Application\Questions\QuestionsListQuery;
use Doctrine\DBAL\Driver\Connection;

class DoctrineQuestionsListQuery extends QuestionsListQuery
{
    /**
     * @var Connection|\Doctrine\DBAL\Connection
     */
    private $connection;

    /**
     * DoctrineQuestionsListQuery constructor.
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }


    /**
     * @inheritDoc
     */
    public function data(array $attributes = []): QueryResult
    {
        $stm = $this->connection->createQueryBuilder()
            ->select('*')
            ->from('questions', 'q')
            ->setMaxResults(12)
            ->setFirstResult(0)
            ->execute();

        return new QueryResult($stm->fetchAll());
    }
}
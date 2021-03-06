<?php

/**
 * This file is part of S4Skeleton project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Infrastructure\Persistence\Doctrine\UserManagement\OAuth2;

use App\Domain\UserManagement\OAuth2\RefreshToken;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;

/**
 * DoctrineRefreshTokensRepository
 *
 * @package App\Infrastructure\Persistence\Doctrine\UserManagement\OAuth2
 */
final class DoctrineRefreshTokensRepository implements RefreshTokenRepositoryInterface
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * Creates a DoctrineRefreshTokenRepository
     *
     * @param EntityManagerInterface|EntityManager $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    /**
     * Creates a new refresh token
     *
     * @return RefreshTokenEntityInterface
     * @throws \Exception
     */
    public function getNewRefreshToken()
    {
        return new RefreshToken();
    }

    /**
     * Create a new refresh token_name.
     *
     * @param RefreshTokenEntityInterface $refreshTokenEntity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function persistNewRefreshToken(RefreshTokenEntityInterface $refreshTokenEntity)
    {
        $this->entityManager->persist($refreshTokenEntity);
        $this->entityManager->flush();

    }

    /**
     * Revoke the refresh token.
     *
     * @param string $tokenId
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function revokeRefreshToken($tokenId)
    {
        $token = $this->entityManager->find(RefreshToken::class, $tokenId);

        if (!$token) return;

        $this->entityManager->remove($token);
        $this->entityManager->flush();

    }

    /**
     * Check if the refresh token has been revoked.
     *
     * @param string $tokenId
     *
     * @return bool Return true if this token has been revoked
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function isRefreshTokenRevoked($tokenId)
    {
        $token = $this->entityManager->find(RefreshToken::class, $tokenId);
        return (!$token);
    }
}

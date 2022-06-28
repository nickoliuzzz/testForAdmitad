<?php

namespace App\Repository;

use App\Entity\AuthenticateToken;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AuthenticateToken>
 *
 * @method AuthenticateToken|null find($id, $lockMode = null, $lockVersion = null)
 * @method AuthenticateToken|null findOneBy(array $criteria, array $orderBy = null)
 * @method AuthenticateToken[]    findAll()
 * @method AuthenticateToken[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuthenticateTokenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AuthenticateToken::class);
    }

    public function findUserByToken(string $token): ?User
    {
        return $this->createQueryBuilder('t')
            ->select('t, u')
            ->leftJoin('t.user', 'u')
            ->where('t.token = :token')
            ->setParameter('token', $token)
            ->getQuery()
            ->getOneOrNullResult()
            ?->getUser()
        ;
    }
}

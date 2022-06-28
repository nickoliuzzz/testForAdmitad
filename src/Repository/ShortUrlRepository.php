<?php

namespace App\Repository;

use App\Dto\StatisticDto;
use App\Entity\ShortUrl;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ShortUrl>
 *
 * @method ShortUrl|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShortUrl|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShortUrl[]    findAll()
 * @method ShortUrl[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShortUrlRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShortUrl::class);
    }

    public function checkUniqueToken(string $token): bool
    {
        return null === $this->findOneBy(['token' => $token]);
    }

    public function add(ShortUrl $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ShortUrl $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getStatistic(StatisticDto $statisticDto): int
    {
        $queryBuilder = $this->createQueryBuilder('s')
            ->select('count(s.id)');

        if ($statisticDto->createdAt !== null) {
            $queryBuilder
                ->andWhere('s.createdAt >= :createdAtStartDay')
                ->setParameter('createdAtStartDay', $statisticDto->createdAt)
                ->andWhere('s.createdAt < :createdAtStartNextDay')
                ->setParameter('createdAtStartNextDay', (new DateTimeImmutable($statisticDto->createdAt))->modify('+1 day'));
        }

        if ($statisticDto->userEmail) {
            $queryBuilder
                ->leftJoin('s.user', 'u')
                ->andWhere('u.email = :userEmail')
                ->setParameter('userEmail', $statisticDto->userEmail);
        }

        return (int) $queryBuilder->getQuery()->getSingleScalarResult();
    }
}

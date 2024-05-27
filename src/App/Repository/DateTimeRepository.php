<?php

namespace App\Repository;

use App\Entity\DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DateTime>
 *
 * @method DateTime|null find($id, $lockMode = null, $lockVersion = null)
 * @method DateTime|null findOneBy(array $criteria, array $orderBy = null)
 * @method DateTime[]    findAll()
 * @method DateTime[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DateTimeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DateTime::class);
    }

    public function add(DateTime $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(DateTime $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}

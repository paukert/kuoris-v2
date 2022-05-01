<?php

namespace App\Repository;

use App\Entity\Event;
use App\Entity\Race;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function findEventsWithNearestDeadline(?string $class, int $maxResults)
    {
        $query = $this->createQueryBuilder('e')
            ->andWhere('e.entryDeadline >= :now')
            ->andWhere('e.isCancelled = false')
            ->setParameter('now', new \DateTime())
            ->orderBy('e.entryDeadline', 'ASC')
            ->setMaxResults($maxResults);

        if ($class) {
            $query->andWhere('e INSTANCE OF :class')
                ->setParameter('class', $this->getEntityManager()->getClassMetadata($class));
        }

        return $query->getQuery()->getResult();
    }

    public function findEventsQuery(?string $hint, bool $excludePastEvents, ?string $class): Query
    {
        $query = $this->createQueryBuilder('e')
            ->orderBy('e.date', 'DESC')
            ->addOrderBy('e.entryDeadline', 'DESC');

        if ($hint) {
            $query->andWhere('e.name LIKE :hint')
                ->setParameter('hint', '%' . $hint . '%');
        }

        if ($excludePastEvents) {
            $query->andWhere('e.date >= :date')
                ->setParameter('date', new \DateTime('-3 days')) // always include events from last 3 days
                ->orderBy('e.date', 'ASC') // change order do ASC
                ->addOrderBy('e.entryDeadline', 'ASC');
        }

        if ($class) {
            $query->andWhere('e INSTANCE OF :class')
                ->setParameter('class', $this->getEntityManager()->getClassMetadata($class));
        }

        return $query->getQuery();
    }

    public function findRemotestRace(): ?Event
    {
        return $this->createQueryBuilder('e')
            ->where('e INSTANCE OF :class')
            ->setParameter('class', $this->getEntityManager()->getClassMetadata(Race::class))
            ->orderBy('e.date', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}

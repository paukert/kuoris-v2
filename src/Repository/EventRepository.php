<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
            ->setParameter('now', new \DateTime())
            ->orderBy('e.entryDeadline', 'ASC')
            ->setMaxResults($maxResults);

        if ($class) {
            $query->andWhere('e INSTANCE OF :class')
                ->setParameter('class', $this->getEntityManager()->getClassMetadata($class));
        }

        return $query->getQuery()->getResult();
    }
}

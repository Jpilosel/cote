<?php

namespace FdjBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * SportRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SportRepository extends EntityRepository
{
    public function findByMatchAVenir($date, $sportId)
    {
        $qb = $this->createQueryBuilder('s');
        $qb->where('s.sportId = :sportId AND s.end >= :date AND s.marketTypeId = 1')
            ->setParameter('sportId', $sportId)
            ->setParameter('date', $date)
            ->orderBy('s.end', 'ASC')
            ->orderBy('s.competition', 'ASC')
            ;

        ;
        return  $qb->getQuery()->getResult();
    }

    public function findByCoteListTennisCote($eventId, $marketType)
    {
        $qb = $this->createQueryBuilder('s');
        $qb->where('s.eventId = :eventId AND s.marketType = :marketType')
            ->setParameter('eventId', $eventId)
            ->setParameter('marketType', $marketType);
        ;
        return  $qb->getQuery()->getResult();
    }
}

<?php

namespace FdjBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * FormulesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FormulesRepository extends EntityRepository
{
    public function findByFormule()
    {
        $qb = $this->createQueryBuilder('f');
        $qb->where('f.sportId = :sport')
            ->setParameter('sport', '600')
            ->andWhere('f.marketTypeGroup = :marketTypeGroup')
            ->setParameter('marketTypeGroup', 'Score Exact')
            ->andWhere('f.scoreTennis = :scoreTennis')
            ->setParameter('scoreTennis', '1');

        ;
        return $qb->getQuery()->getResult();
    }

    public function findByCoteListTennisCote($sportId, $marketTypeId, $Ok)
    {
        $qb = $this->createQueryBuilder('f');
        $qb->where('f.sportId = :sportId AND f.marketTypeId = :marketTypeId AND f.ok = :Ok')
            ->setParameter('sportId', $sportId)
            ->setParameter('Ok', $Ok)
            ->setParameter('marketTypeId', $marketTypeId);


        ;
        return  $qb->getQuery()->getResult();
    }
}

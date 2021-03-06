<?php

namespace FdjBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ApiResultatTennisRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ApiResultatTennisRepository extends EntityRepository
{
    public function findByFullIdJoueurs($idJoueur)
    {
        $qb = $this->createQueryBuilder('a');
        $qb->where('a.joueur1Id = :idJoueur OR a.joueur2Id = :idJoueur')
            ->setParameter('idJoueur', $idJoueur)
            ->orderBy('a.date', 'DESC');

        ;
        return  $qb->getQuery()->getResult();
    }
}

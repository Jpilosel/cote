<?php

namespace ResultBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ResultatRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ResultatRepository extends EntityRepository
{
    public function findByMySearch($data)
    {
        $qb = $this->createQueryBuilder('r');

            if($data['cote']) {
                $qb->where('r.cote1 = :cote1')//base de donné = :se que lo'on saisie dans le formulaire
                        ->setParameter('cote1', $data['cote'])
                    ->orWhere('r.cote2 = :cote2')
                        ->setParameter('cote2', $data['cote']);
                if ($data['nbResult'] == 3) {
                    $qb->orWhere('r.coteNull = :coteNull')
                            ->setParameter('coteNull', $data['cote']);
                }
            }
                $qb->andwhere('r.nbResult = :nbResult')
                ->setParameter('nbResult', $data['nbResult']);
            if ($data['sport']) {
                $qb->andWhere('r.sport = :sport')
                    ->setParameter('sport', $data['sport']);
            }
            if ($data['sexe']) {
                $qb->andWhere('r.sexe = :sexe')
                    ->setParameter('sexe', $data['sexe']);
            }
        ;
        return  $qb->getQuery()->getResult();
    }
    public function findByResult($data)
    {
        $qb = $this->createQueryBuilder('r');
            $qb->where('r.nbResult = :nbResult')
            ->setParameter('nbResult', $data['nbResult']);
        if($data['sport']) {
            $qb->andWhere('r.sport = :sport')
                ->setParameter('sport', $data['sport']);
        }
        if($data['sexe']) {
            $qb->andWhere('r.sexe = :sexe')
                ->setParameter('sexe', $data['sexe']);
        }
        ;
        return  $qb->getQuery()->getResult();
    }
}

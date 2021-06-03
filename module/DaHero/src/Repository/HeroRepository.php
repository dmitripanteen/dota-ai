<?php

namespace DaHero\Repository;

use DaBase\Repository\CustomRepository;
use DaHero\Entity\Hero;

class HeroRepository extends CustomRepository
{
    public function findOneByAlias(string $alias){
        $entityManager = $this->getEntityManager();
        $queryBuilder = $entityManager->createQueryBuilder();
        $queryBuilder->select('h')
            ->from(Hero::class, 'h')
            ->where('h.alias = :alias')
            ->setParameter('alias', $alias);
        $neutralItem = $queryBuilder->getQuery()->getOneOrNullResult();
        return $neutralItem;
    }
}
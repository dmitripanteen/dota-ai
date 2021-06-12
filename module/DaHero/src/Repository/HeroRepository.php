<?php

namespace DaHero\Repository;

use DaBase\Repository\CustomRepository;
use DaHero\Entity\Hero;

class HeroRepository extends CustomRepository
{
    public function findOneByAlias(string $alias)
    {
        $entityManager = $this->getEntityManager();
        $queryBuilder = $entityManager->createQueryBuilder();
        $queryBuilder->select('h')
            ->from(Hero::class, 'h')
            ->where('h.alias = :alias')
            ->setParameter('alias', $alias);
        $hero= $queryBuilder->getQuery()->getOneOrNullResult();
        return $hero;
    }

    public function findByMainAttr(int $mainAttr)
    {
        $entityManager = $this->getEntityManager();
        $qb = $entityManager->createQueryBuilder();
        $qb->select('h')
            ->from(Hero::class, 'h')
            ->where('h.mainAttr = :mainAttr')
            ->setParameter('mainAttr', $mainAttr);
        $heroes = $qb->getQuery()->getArrayResult();
        return $heroes;
    }
}
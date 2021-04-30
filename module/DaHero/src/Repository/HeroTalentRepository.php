<?php

namespace DaHero\Repository;

use DaBase\Repository\CustomRepository;
use DaHero\Entity\Hero;
use DaHero\Entity\HeroTalent;

class HeroTalentRepository extends CustomRepository
{
    public function findTalentsByHero(Hero $hero)
    {
        $entityManager = $this->getEntityManager();

        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('ht')
            ->from(HeroTalent::class, 'ht')
            ->where('ht.hero = :hero')
            ->orderBy('ht.level', 'ASC')
            ->setParameter('hero', $hero);

        $talents = $queryBuilder->getQuery()->getResult();

        return $talents;
    }
}
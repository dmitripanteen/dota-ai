<?php

namespace DaHero\Repository;

use DaBase\Repository\CustomRepository;
use DaHero\Entity\Hero;
use DaHero\Entity\HeroAbility;

class HeroAbilityRepository extends CustomRepository
{
    public function findAbilitiesByHero(Hero $hero)
    {
        $entityManager = $this->getEntityManager();

        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('ha')
            ->from(HeroAbility::class, 'ha')
            ->where('ha.hero = :hero')
            ->orderBy('ha.abilityNumber', 'ASC')
            ->setParameter('hero', $hero);

        $talents = $queryBuilder->getQuery()->getResult();

        return $talents;
    }
}
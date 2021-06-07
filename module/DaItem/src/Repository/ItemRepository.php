<?php

namespace DaItem\Repository;

use DaBase\Repository\CustomRepository;
use DaItem\Entity\Item;

class ItemRepository extends CustomRepository
{
    public function findOneByAlias(string $alias)
    {
        $entityManager = $this->getEntityManager();
        $queryBuilder = $entityManager->createQueryBuilder();
        $queryBuilder->select('i')
            ->from(Item::class, 'i')
            ->where('i.alias = :alias')
            ->setParameter('alias', $alias);
        $item = $queryBuilder->getQuery()->getOneOrNullResult();
        return $item;
    }
}
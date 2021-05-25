<?php

namespace DaItem\Repository;

use DaBase\Repository\CustomRepository;
use DaItem\Entity\NeutralItem;

class NeutralItemRepository extends CustomRepository
{
    public function findOneByAlias(string $alias){
        $entityManager = $this->getEntityManager();
        $queryBuilder = $entityManager->createQueryBuilder();
        $queryBuilder->select('ni')
            ->from(NeutralItem::class, 'ni')
            ->where('ni.alias = :alias')
            ->setParameter('alias', $alias);
        $neutralItem = $queryBuilder->getQuery()->getOneOrNullResult();
        return $neutralItem;
    }
}
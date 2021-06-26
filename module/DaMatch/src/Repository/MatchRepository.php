<?php

namespace DaMatch\Repository;

use DaBase\Repository\CustomRepository;

class MatchRepository extends CustomRepository
{
    public function listAll()
    {
        $qb = $this->createQueryBuilder('m');
        $query = $qb->orderBy('m.startTime', 'DESC');
        return $query->getQuery();
    }
}
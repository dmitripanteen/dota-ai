<?php

namespace DaMatch\Repository;

use DaBase\Repository\CustomRepository;
use DaHero\Entity\Hero;
use DaItem\Entity\Item;
use DaItem\Entity\NeutralItem;

class MatchPlayerRepository extends CustomRepository
{
    public function getItemUsages(Item $item, $onlyWonGames = false)
    {
        $qb = $this->createQueryBuilder('mp');
        $qb->select('COUNT(DISTINCT(mp.match))');
        $qb->where(
            $qb->expr()->orX(
                $qb->expr()->eq('mp.backpack0', ':item'),
                $qb->expr()->eq('mp.backpack1', ':item'),
                $qb->expr()->eq('mp.backpack2', ':item'),
                $qb->expr()->eq('mp.backpack3', ':item'),
                $qb->expr()->eq('mp.item0', ':item'),
                $qb->expr()->eq('mp.item1', ':item'),
                $qb->expr()->eq('mp.item2', ':item'),
                $qb->expr()->eq('mp.item3', ':item'),
                $qb->expr()->eq('mp.item4', ':item'),
                $qb->expr()->eq('mp.item5', ':item')
            )
        );
        if ($onlyWonGames) {
            $qb->andWhere(
                $qb->expr()->eq('mp.win', 1)
            );
        }
        $qb->setParameter('item', $item->getId());
        return $qb->getQuery()->getResult()[0][1];
    }

    public function getNumberOfMatches()
    {
        $qb = $this->createQueryBuilder('mp');
        $qb->select('DISTINCT(mp.match)');
        return count($qb->getQuery()->getResult());
    }

    public function getNeutralItemUsages(NeutralItem $neutralItem, $onlyWonGames = false)
    {
        $qb = $this->createQueryBuilder('mp');
        $qb->select('DISTINCT(mp.match)');
        $qb->where(
            $qb->expr()->andX(
                $qb->expr()->eq('mp.neutralItem', ':neutralItem')
            )
        );
        if ($onlyWonGames) {
            $qb->andWhere(
                $qb->expr()->eq('mp.win', 1)
            );
        }
        $qb->setParameter('neutralItem', $neutralItem->getId());
        return count($qb->getQuery()->getResult());
    }

    public function getHeroPicks(Hero $hero, $onlyWonGames = false)
    {
        $qb = $this->createQueryBuilder('mp');
        $qb->select('DISTINCT(mp.match)');
        $qb->where(
            $qb->expr()->andX(
                $qb->expr()->eq('mp.hero', ':hero')
            )
        );
        if ($onlyWonGames) {
            $qb->andWhere(
                $qb->expr()->eq('mp.win', 1)
            );
        }
        $qb->setParameter('hero', $hero->getId());
        return count($qb->getQuery()->getResult());
    }
}
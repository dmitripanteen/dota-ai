<?php

namespace DaMatch\Controller\Factory;

use DaHero\Entity\Hero;
use DaItem\Entity\Item;
use DaItem\Entity\NeutralItem;
use DaMatch\Controller\MatchController;
use DaMatch\Entity\Match;
use DaMatch\Entity\MatchPlayer;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class MatchControllerFactory implements FactoryInterface
{
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    )
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        return new MatchController(
            $entityManager,
            $entityManager->getRepository(Hero::class),
            $entityManager->getRepository(Item::class),
            $entityManager->getRepository(NeutralItem::class),
            $entityManager->getRepository(Match::class),
            $entityManager->getRepository(MatchPlayer::class)
        );
    }
}
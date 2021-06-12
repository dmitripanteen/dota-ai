<?php

namespace DaHero\Service\Factory;

use DaHero\Entity\Hero;
use DaHero\Entity\HeroAbility;
use DaHero\Entity\HeroTalent;
use DaHero\Service\HeroBuilderService;
use DaItem\Entity\Item;
use DaItem\Entity\NeutralItem;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class HeroBuilderServiceFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null         $options
     *
     * @return HeroBuilderService|object
     */
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ) {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        return new HeroBuilderService(
            $entityManager,
            $entityManager->getRepository(Hero::class),
            $entityManager->getRepository(Item::class),
            $entityManager->getRepository(NeutralItem::class),
            $entityManager->getRepository(HeroTalent::class),
            $entityManager->getRepository(HeroAbility::class)
        );
    }
}
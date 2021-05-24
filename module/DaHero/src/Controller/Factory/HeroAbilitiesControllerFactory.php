<?php

namespace DaHero\Controller\Factory;

use DaHero\Controller\HeroAbilitiesController;
use DaHero\Entity\Hero;
use DaHero\Entity\HeroAbility;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class HeroAbilitiesControllerFactory implements FactoryInterface
{
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ) {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        return new HeroAbilitiesController(
            $entityManager->getRepository(Hero::class),
            $entityManager->getRepository(HeroAbility::class),
            $entityManager
        );
    }
}
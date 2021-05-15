<?php

namespace DaHero\Controller\Factory;

use DaHero\Controller\HeroTalentController;
use DaHero\Entity\Hero;
use DaHero\Entity\HeroTalent;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class HeroTalentControllerFactory implements FactoryInterface
{
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    )
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        return new HeroTalentController(
            $entityManager->getRepository(Hero::class),
            $entityManager->getRepository(HeroTalent::class),
            $entityManager
        );
    }
}
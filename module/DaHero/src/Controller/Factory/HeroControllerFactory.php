<?php

namespace DaHero\Controller\Factory;

use DaHero\Controller\HeroController;
use DaHero\Entity\Hero;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class HeroControllerFactory implements FactoryInterface
{
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    )
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        return new HeroController(
            $entityManager->getRepository(Hero::class)
        );
    }
}
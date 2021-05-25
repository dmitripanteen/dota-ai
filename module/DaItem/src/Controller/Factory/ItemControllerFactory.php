<?php

namespace DaItem\Controller\Factory;

use DaItem\Controller\ItemController;
use DaItem\Entity\Item;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class ItemControllerFactory implements FactoryInterface
{
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    )
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        return new ItemController(
            $entityManager,
            $entityManager->getRepository(Item::class)
        );
    }
}
<?php

namespace DaItem\Controller\Factory;

use DaItem\Controller\NeutralItemController;
use DaItem\Entity\NeutralItem;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class NeutralItemControllerFactory implements FactoryInterface
{
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    )
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        return new NeutralItemController(
            $entityManager,
            $entityManager->getRepository(NeutralItem::class)
        );
    }
}
<?php

namespace DaItem\Form\Factory;

use DaItem\Entity\Item;
use DaItem\Form\ItemForm;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class ItemFormFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null         $options
     *
     * @return ItemForm|object
     */
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ) {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        return new ItemForm(
            $entityManager,
            $entityManager->getRepository(Item::class)
        );
    }
}
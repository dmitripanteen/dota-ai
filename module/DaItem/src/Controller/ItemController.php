<?php

namespace DaItem\Controller;

use DaItem\Repository\ItemRepository;
use Doctrine\ORM\EntityManager;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class ItemController extends AbstractActionController
{

    /**
     * @var ItemRepository
     */
    private $itemRepository;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * ItemController constructor.
     *
     * @param $entityManager
     * @param $itemRepository
     */
    public function __construct(
        $entityManager,
        $itemRepository
    )
    {
        $this->entityManager = $entityManager;
        $this->itemRepository = $itemRepository;
    }

    public function itemsListAction()
    {
        $items = $this->itemRepository->findAll();
        return new ViewModel(
            [
                'items' => $items
            ]
        );
    }

    public function singleItemAction()
    {
        $itemAlias = $this->params()->fromRoute('item');
        /**
         * @var $item
         */
        $item = $this->itemRepository->findOneByAlias($itemAlias);

        return new ViewModel(
            [
                'item' => $item
            ]
        );
    }
}
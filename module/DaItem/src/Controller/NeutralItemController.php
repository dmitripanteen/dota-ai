<?php

namespace DaItem\Controller;

use DaItem\Repository\NeutralItemRepository;
use Doctrine\ORM\EntityManager;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class NeutralItemController extends AbstractActionController
{

    /**
     * @var NeutralItemRepository
     */
    private $neutralItemRepository;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * NeutralItemController constructor.
     *
     * @param $entityManager
     * @param $neutralItemRepository
     */
    public function __construct(
        $entityManager,
        $neutralItemRepository
    )
    {
        $this->entityManager = $entityManager;
        $this->neutralItemRepository = $neutralItemRepository;
    }

    public function neutralItemsListAction()
    {
        $neutralItems = $this->neutralItemRepository->findAll();
        return new ViewModel(
            [
                'neutralItems' => $neutralItems
            ]
        );
    }

    public function singleItemAction()
    {
        $itemAlias = $this->params()->fromRoute('neutralItem');
        /**
         * @var $neutralItem
         */
        $neutralItem = $this->neutralItemRepository->findOneByAlias($itemAlias);

        return new ViewModel(
            [
                'neutralItem' => $neutralItem
            ]
        );
    }
}
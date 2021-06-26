<?php

namespace DaItem\Controller;

use DaItem\Entity\NeutralItem;
use DaItem\Form\NeutralItemForm;
use DaItem\Repository\NeutralItemRepository;
use Doctrine\ORM\EntityManager;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;
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
    ) {
        $this->entityManager = $entityManager;
        $this->neutralItemRepository = $neutralItemRepository;
    }

    public function neutralItemsListAction()
    {
        $neutralItemsTier1 = $this->neutralItemRepository->findArrayByTier(1);
        $neutralItemsTier2 = $this->neutralItemRepository->findArrayByTier(2);
        $neutralItemsTier3 = $this->neutralItemRepository->findArrayByTier(3);
        $neutralItemsTier4 = $this->neutralItemRepository->findArrayByTier(4);
        $neutralItemsTier5 = $this->neutralItemRepository->findArrayByTier(5);
        return new ViewModel(
            [
                'tier1' => $neutralItemsTier1,
                'tier2' => $neutralItemsTier2,
                'tier3' => $neutralItemsTier3,
                'tier4' => $neutralItemsTier4,
                'tier5' => $neutralItemsTier5,
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

    public function addAction()
    {
        $form = new NeutralItemForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (!$request->isPost()) {
            return ['form' => $form];
        }

        $item = new NeutralItem();
        $form->setInputFilter($form->getInputFilter());
        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return ['form' => $form];
        }

        $formData = $form->getData();
        $itemAlias = strtolower(str_replace('\'', '', str_replace(' ', '_', $formData['name'])));
        $item->setName($formData['name'])
            ->setAlias($itemAlias)
            ->setLore($formData['lore'])
            ->setDescription($formData['description'])
            ->setDmgIncrease($formData['dmgIncrease'])
            ->setStrIncrease($formData['strIncrease'])
            ->setAgiIncrease($formData['agiIncrease'])
            ->setIntIncrease($formData['intIncrease'])
            ->setHpIncrease($formData['hpIncrease'])
            ->setMpIncrease($formData['mpIncrease'])
            ->setHpRegenIncrease($formData['hpRegenIncrease'])
            ->setMpRegenIncrease($formData['mpRegenIncrease'])
            ->setArmorIncrease($formData['armorIncrease'])
            ->setMoveSpeedIncrease($formData['msIncrease'])
            ->setImage($formData['image'])
            ->setTier($formData['tier']);
        $this->entityManager->persist($item);
        $this->entityManager->flush();
        return $this->redirect()->toRoute(
            'neutral-items/neutral-item-page',
            [
                'action'      => 'singleItem',
                'neutralItem' => $itemAlias
            ]
        );
    }

    public function editAction()
    {
        $itemAlias = $this->params()->fromRoute('neutralItem', '');

        if (!$itemAlias) {
            return $this->redirect()->toRoute(
                'neutral-items/add-item',
                [
                    'action' => 'add',
                ]
            );
        }

        try {
            $item = $this->neutralItemRepository->findOneByAlias($itemAlias);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute(
                'neutral-items',
                [
                    'action' => 'neutralItemsList',
                ]
            );
        }

        $form = new NeutralItemForm();
        $form->bind($item);
        $form->get('submit')->setValue('Edit');

        $request = $this->getRequest();
        $viewData = [
            'neutralItem' => $item,
            'form'        => $form
        ];

        if (!$request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($form->getInputFilter());
        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return $viewData;
        }

        $this->entityManager->persist($item);
        $this->entityManager->flush();

        return $this->redirect()->toRoute(
            'neutral-items/neutral-item-page',
            [
                'action'      => 'singleItem',
                'neutralItem' => $itemAlias
            ]
        );
    }

    public function neutralItemDataAction(){
        $item = $this->params()->fromQuery('neutral-item', '');
        $neutralItem = $this->neutralItemRepository->findById($item)[0];
        return new JsonModel(
            [
                'item' => $neutralItem->getImage(),
            ]
        );
    }
}
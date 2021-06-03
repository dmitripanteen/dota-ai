<?php

namespace DaItem\Controller;

use DaItem\Entity\NeutralItem;
use DaItem\Form\NeutralItemForm;
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
                'action' => 'singleItem',
                'neutralItem'   => $itemAlias
            ]
        );
    }
}
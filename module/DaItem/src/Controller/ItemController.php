<?php

namespace DaItem\Controller;

use DaItem\Entity\Item;
use DaItem\Form\ItemForm;
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
    ) {
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

    public function addAction()
    {
        $form = new ItemForm(
            $this->entityManager,
            $this->itemRepository
        );
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (!$request->isPost()) {
            return ['form' => $form];
        }

        $item = new Item();
        $form->setInputFilter($form->getInputFilter());
        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return ['form' => $form];
        }

        $formData = $form->getData();
        $itemAlias = strtolower(str_replace('\'', '', str_replace(' ', '_', $formData['name'])));
        $buildsInto = [];
        foreach ($formData['buildsInto'] as $parentItem){
            $buildsInto[] = $parentItem[0];
        }
        $item->setName($formData['name'])
            ->setAlias($itemAlias)
            ->setLore($formData['lore'])
            ->setDescription($formData['description'])
            ->setPrice($formData['price'])
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
            ->setType($formData['type'])
            ->setCategory($formData['category'])
            ->setBuildsInto(json_encode($buildsInto))
            ->setIsRecipeRequired($formData['isRecipeRequired']);
        $this->entityManager->persist($item);
        $this->entityManager->flush();
        return $this->redirect()->toRoute(
            'items/item-page',
            [
                'action' => 'singleItem',
                'item'   => $itemAlias
            ]
        );
    }
}
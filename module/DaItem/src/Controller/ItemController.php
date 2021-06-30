<?php

namespace DaItem\Controller;

use DaItem\Entity\Item;
use DaItem\Form\ItemForm;
use DaItem\Helper\ItemHelper;
use DaItem\Repository\ItemRepository;
use DaMatch\Repository\MatchPlayerRepository;
use Doctrine\ORM\EntityManager;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;
use Laminas\View\Model\ViewModel;

class ItemController extends AbstractActionController
{

    /**
     * @var ItemRepository
     */
    private $itemRepository;

    /**
     * @var MatchPlayerRepository
     */
    private $matchPlayerRepository;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * ItemController constructor.
     *
     * @param $entityManager
     * @param $itemRepository
     * @param $matchPlayerRepository
     */
    public function __construct(
        $entityManager,
        $itemRepository,
        $matchPlayerRepository
    ) {
        $this->entityManager = $entityManager;
        $this->itemRepository = $itemRepository;
        $this->matchPlayerRepository = $matchPlayerRepository;
    }

    public function itemsListAction()
    {
        for ($i = 1; $i <= 12; $i++) {
            ${'items' . $i} = $this->itemRepository->findBy(
                [
                    'category' => $i,
                ],
                [
                    'name' => 'ASC',
                ]
            );
        }
        return new ViewModel(
            [
                'itemsConsumables' => $items1,
                'itemsAttributes'  => $items2,
                'itemsEquipment'   => $items3,
                'itemsMisc'        => $items4,
                'itemsSecretShop'  => $items5,
                'itemsRoshan'      => $items6,
                'itemsAccessories' => $items7,
                'itemsSupport'     => $items8,
                'itemsMagical'     => $items9,
                'itemsArmor'       => $items10,
                'itemsWeapons'     => $items11,
                'itemsArtifacts'   => $items12,
            ]
        );
    }

    public function singleItemAction()
    {
        $itemAlias = $this->params()->fromRoute('item');
        /**
         * @var $item Item
         */
        $item = $this->itemRepository->findOneByAlias($itemAlias);
        $itemBuildsInto = [];
        foreach (json_decode($item->getBuildsInto()) as $parentItem) {
            $itemBuildsInto[] = $this->itemRepository->findById($parentItem);
        }
        $childItems = $this->itemRepository->getChildItems($item->getId());
        $recipeImgTop = ItemHelper::$recipeMap['top'][count($itemBuildsInto)];
        $recipeImgBottom = ItemHelper::$recipeMap['bottom'][count($childItems) + (int)$item->getIsRecipeRequired()];
        return new ViewModel(
            [
                'item'            => $item,
                'itemBuildsInto'  => $itemBuildsInto,
                'childItems'      => $childItems,
                'recipeImgTop'    => $recipeImgTop,
                'recipeImgBottom' => $recipeImgBottom
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
        foreach ($formData['buildsInto'] as $parentItem) {
            $buildsInto[] = $parentItem;
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

    public function editAction()
    {
        $itemAlias = $this->params()->fromRoute('item', '');

        if (!$itemAlias) {
            return $this->redirect()->toRoute(
                'items/add-item',
                [
                    'action' => 'add',
                ]
            );
        }

        try {
            $item = $this->itemRepository->findOneByAlias($itemAlias);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute(
                'items',
                [
                    'action' => 'itemsList',
                ]
            );
        }

        $form = new ItemForm(
            $this->entityManager,
            $this->itemRepository
        );
        $form->bind($item);
        $form->get('submit')->setValue('Edit');

        $request = $this->getRequest();
        $viewData = [
            'item' => $item,
            'form' => $form
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
            'items/item-page',
            [
                'action' => 'singleItem',
                'item'   => $itemAlias
            ]
        );
    }

    public function itemDataAction()
    {
        $items = $this->params()->fromQuery('items', '');
        $itemImagesArr = [];
        if ($items) {
            $itemIdsFromQuery = explode(',', $items);
            foreach ($itemIdsFromQuery as $itemFromQuery) {
                $itemRes = $this->itemRepository->findById($itemFromQuery);
                $itemImagesArr[] = $itemRes->getImage();
            }
        }
        return new JsonModel(
            [
                'items' => $itemImagesArr,
            ]
        );
    }

    public function itemStatsAction()
    {
        $sort = $this->params()->fromQuery('sort', 'name');
        if (!in_array($sort, $this->itemRepository->sortWhitelist)) {
            $sort = 'name';
        }
        $itemsSorted = [];
        $maxTotalUse = 0;
        $maxUseRate = 0;
        $maxWinRate = 0;
        $items = $this->itemRepository->getAll();
        foreach ($items as $item) {
            $itemUsagesTotal = $this->matchPlayerRepository->getItemUsages($item);
            $itemUsagesWon = $this->matchPlayerRepository->getItemUsages($item, true);
            $totalGames = $this->matchPlayerRepository->getNumberOfMatches();
            $useRate = $totalGames ? $itemUsagesTotal / $totalGames : 0;
            $winRate = $itemUsagesTotal ? $itemUsagesWon / $itemUsagesTotal : 0;
            $itemsSorted[] = [
                'item'     => $item,
                'itemName' => $item->getName(),
                'totalUse' => $itemUsagesTotal,
                'useRate'  => $useRate,
                'winRate'  => $winRate,
            ];
            $maxTotalUse = $itemUsagesTotal > $maxTotalUse ? $itemUsagesTotal : $maxTotalUse;
            $maxWinRate = $winRate > $maxWinRate ? $winRate : $maxWinRate;
            $maxUseRate = $useRate > $maxUseRate ? $useRate : $maxUseRate;
        }
        if ($sort == 'name') {
            usort(
                $itemsSorted, function ($a, $b) {
                return $a['itemName'] <=> $b['itemName'];
            }
            );
        } elseif ($sort == 'winRate') {
            usort(
                $itemsSorted, function ($a, $b) {
                return $b['winRate'] <=> $a['winRate'];
            }
            );
        } elseif ($sort == 'useRate') {
            usort(
                $itemsSorted, function ($a, $b) {
                return $b['useRate'] <=> $a['useRate'];
            }
            );
        } elseif ($sort == 'totalUse') {
            usort(
                $itemsSorted, function ($a, $b) {
                return $b['totalUse'] <=> $a['totalUse'];
            }
            );
        }
        return new ViewModel(
            [
                'items'       => $itemsSorted,
                'maxTotalUse' => $maxTotalUse,
                'maxWinRate'  => $maxWinRate,
                'maxUseRate'  => $maxUseRate
            ]
        );
    }
}
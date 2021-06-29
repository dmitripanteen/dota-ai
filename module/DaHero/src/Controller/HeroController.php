<?php

namespace DaHero\Controller;

use DaHero\Entity\Hero;
use DaHero\Entity\HeroAbility;
use DaHero\Entity\HeroTalent;
use DaHero\Form\HeroForm;
use DaHero\Repository\HeroAbilityRepository;
use DaHero\Repository\HeroRepository;
use DaHero\Repository\HeroTalentRepository;
use DaHero\Service\HeroBuilderService;
use DaItem\Repository\ItemRepository;
use DaItem\Repository\NeutralItemRepository;
use DaMatch\Repository\MatchPlayerRepository;
use Doctrine\ORM\EntityManager;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;
use Laminas\View\Model\ViewModel;

class HeroController extends AbstractActionController
{

    /**
     * @var HeroRepository
     */
    private $heroRepository;

    /**
     * @var HeroTalentRepository
     */
    private $heroTalentRepository;

    /**
     * @var HeroAbilityRepository
     */
    private $heroAbilityRepository;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var ItemRepository
     */
    protected $itemRepository;

    /**
     * @var NeutralItemRepository
     */
    protected $neutralItemRepository;

    /**
     * @var HeroBuilderService
     */
    protected $heroBuilderService;

    /**
     * @var MatchPlayerRepository
     */
    private $matchPlayerRepository;

    /**
     * HeroController constructor.
     *
     * @param $heroRepository
     * @param $heroTalentRepository
     * @param $heroAbilityRepository
     * @param $itemRepository
     * @param $neutralItemRepository
     * @param $entityManager
     * @param $heroBuilderService
     * @param $matchPlayerRepository
     */
    public function __construct(
        $heroRepository,
        $heroTalentRepository,
        $heroAbilityRepository,
        $itemRepository,
        $neutralItemRepository,
        $entityManager,
        $heroBuilderService,
        $matchPlayerRepository
    ) {
        $this->heroRepository = $heroRepository;
        $this->heroTalentRepository = $heroTalentRepository;
        $this->heroAbilityRepository = $heroAbilityRepository;
        $this->itemRepository = $itemRepository;
        $this->neutralItemRepository = $neutralItemRepository;
        $this->entityManager = $entityManager;
        $this->heroBuilderService = $heroBuilderService;
        $this->matchPlayerRepository = $matchPlayerRepository;
    }

    public function indexAction()
    {
        $strHeroes = $this->heroRepository->findByMainAttr(1);
        $agiHeroes = $this->heroRepository->findByMainAttr(2);
        $intHeroes = $this->heroRepository->findByMainAttr(3);
        return new ViewModel(
            [
                'heroes' => [
                    'str' => $strHeroes,
                    'agi' => $agiHeroes,
                    'int' => $intHeroes,
                ]
            ]
        );
    }

    public function addAction()
    {
        $form = new HeroForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (!$request->isPost()) {
            return ['form' => $form];
        }

        $hero = new Hero();
        $form->setInputFilter($form->getInputFilter());
        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return ['form' => $form];
        }

        $formData = $form->getData();
        $heroAlias = strtolower(str_replace('\'', '', str_replace([' ', '-'], '_', $formData['name'])));
        $hero->setName($formData['name'])
            ->setAlias($heroAlias)
            ->setLore($formData['lore'])
            ->setMainAttribute($formData['mainAttr'])
            ->setBaseStr($formData['baseStr'])
            ->setBaseAgi($formData['baseAgi'])
            ->setBaseInt($formData['baseInt'])
            ->setStrGain($formData['strGain'])
            ->setAgiGain($formData['agiGain'])
            ->setIntGain($formData['intGain'])
            ->setBaseArmor($formData['baseArmor'])
            ->setBaseDamageMin($formData['baseDamageMin'])
            ->setBaseDamageMax($formData['baseDamageMax'])
            ->setBaseHp($formData['baseHp'])
            ->setBaseMoveSpeed($formData['baseMoveSpeed']);
        $this->entityManager->persist($hero);
        $this->entityManager->flush();
        return $this->redirect()->toRoute(
            'talents/add-hero-talents',
            [
                'action' => 'addHeroTalents',
                'hero'   => $heroAlias
            ]
        );
    }

    public function editAction()
    {
        $heroAlias = $this->params()->fromRoute('hero', '');

        if (!$heroAlias) {
            return $this->redirect()->toRoute(
                'heroes/hero-crud',
                [
                    'action' => 'add',
                ]
            );
        }

        try {
            $hero = $this->heroRepository->findOneByAlias($heroAlias);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute(
                'heroes',
                [
                    'action' => 'index',
                ]
            );
        }

        $form = new HeroForm();
        $form->bind($hero);
        $form->setAttribute('class', 'hero-form');
        $form->get('submit')->setValue('Edit');

        $request = $this->getRequest();
        $viewData = [
            'hero' => $hero,
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

        $this->entityManager->persist($hero);
        $this->entityManager->flush();

        return $this->redirect()->toRoute(
            'heroes/hero-page',
            [
                'action' => 'singleHero',
                'hero'   => $heroAlias
            ]
        );
    }

    public function deleteAction()
    {
    }

    public function singleHeroAction()
    {
        $heroAlias = $this->params()->fromRoute('hero', 0);
        /**
         * @var $hero Hero
         */
        $hero = $this->heroRepository->findOneByAlias($heroAlias);
        $talents = $this->heroTalentRepository->findTalentsByHero($hero);
        $abilities = $this->heroAbilityRepository->findAbilitiesByHero($hero);
        return new ViewModel(
            [
                'hero'          => $hero,
                'hero_computed' => [
                    'lvl1'  => $this->heroDataAction($hero->getId(), 1),
                    'lvl15' => $this->heroDataAction($hero->getId(), 15),
                    'lvl25' => $this->heroDataAction($hero->getId(), 25),
                    'lvl30' => $this->heroDataAction($hero->getId(), 30),
                ],
                'talents'       => $talents,
                'abilities'     => $abilities
            ]
        );
    }

    public function heroBuilderAction()
    {
        $heroes = $this->heroBuilderService->getHeroesList();
        $items = $this->itemRepository->findBy(
            [],
            ['name' => 'ASC']
        );
        $neutralItems = $this->neutralItemRepository->findBy(
            [],
            ['name' => 'ASC']
        );
        return new ViewModel(
            [
                'heroes'       => $heroes,
                'items'        => $items,
                'neutralItems' => $neutralItems
            ]
        );
    }

    public function heroDataAction($heroId = null, $level=null)
    {
        $heroId = $heroId ?? $this->params()->fromRoute('heroId', 0);
        $level = $level ?? $this->params()->fromQuery('level', 1);
        $level = $level < 1 ? 1 : ($level > 30 ? 30 : $level);
        $talents = $this->params()->fromQuery('talents', '');
        $items = $this->params()->fromQuery('items', '');
        $neutralItem = $this->params()->fromQuery('neutral-item', '');
        $hero = $this->heroRepository->findById($heroId)[0];

        $heroData = $this->heroBuilderService->computeHeroStats($hero, $level, $talents, $items, $neutralItem);
        return new JsonModel(
            [
                'hero' => $heroData,
            ]
        );
    }

    public function heroStatsAction()
    {
        $sort = $this->params()->fromQuery('sort', 'name');
        if (!in_array($sort, $this->heroRepository->sortWhitelist)) {
            $sort = 'name';
        }
        $heroesSorted = [];
        $maxTotalPicks = 0;
        $maxPickRate = 0;
        $maxWinRate = 0;
        $heroes = $this->heroRepository->getAll();
        foreach ($heroes as $hero) {
            $heroPicksTotal = $this->matchPlayerRepository->getHeroPicks($hero);
            $heroPicksWon = $this->matchPlayerRepository->getHeroPicks($hero, true);
            $totalGames = $this->matchPlayerRepository->getNumberOfMatches();
            $pickRate = $totalGames ? $heroPicksTotal / $totalGames : 0;
            $winRate = $heroPicksTotal ? $heroPicksWon / $heroPicksTotal : 0;
            $heroesSorted[] = [
                'hero'     => $hero,
                'heroName' => $hero->getName(),
                'totalPicks' => $heroPicksTotal,
                'pickRate'  => $pickRate,
                'winRate'  => $winRate,
            ];
            $maxTotalPicks = $heroPicksTotal > $maxTotalPicks ? $heroPicksTotal : $maxTotalPicks;
            $maxWinRate = $winRate > $maxWinRate ? $winRate : $maxWinRate;
            $maxPickRate = $pickRate > $maxPickRate ? $pickRate : $maxPickRate;
        }
        if ($sort == 'name') {
            usort(
                $heroesSorted, function ($a, $b) {
                return $a['heroName'] <=> $b['heroName'];
            }
            );
        } elseif ($sort == 'winRate') {
            usort(
                $heroesSorted, function ($a, $b) {
                return $b['winRate'] <=> $a['winRate'];
            }
            );
        } elseif ($sort == 'pickRate') {
            usort(
                $heroesSorted, function ($a, $b) {
                return $b['pickRate'] <=> $a['pickRate'];
            }
            );
        } elseif ($sort == 'totalPicks') {
            usort(
                $heroesSorted, function ($a, $b) {
                return $b['totalPicks'] <=> $a['totalPicks'];
            }
            );
        }
        return new ViewModel(
            [
                'heroes'       => $heroesSorted,
                'maxTotalPicks' => $maxTotalPicks,
                'maxWinRate'  => $maxWinRate,
                'maxPickRate'  => $maxPickRate
            ]
        );
    }
}
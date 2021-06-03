<?php

namespace DaHero\Controller;

use DaHero\Entity\Hero;
use DaHero\Form\HeroForm;
use DaHero\Repository\HeroAbilityRepository;
use DaHero\Repository\HeroRepository;
use DaHero\Repository\HeroTalentRepository;
use Doctrine\ORM\EntityManager;
use Laminas\Mvc\Controller\AbstractActionController;
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
     * HeroController constructor.
     *
     * @param $heroRepository
     * @param $heroTalentRepository
     * @param $heroAbilityRepository
     * @param $entityManager
     */
    public function __construct(
        $heroRepository,
        $heroTalentRepository,
        $heroAbilityRepository,
        $entityManager
    )
    {
        $this->heroRepository = $heroRepository;
        $this->heroTalentRepository = $heroTalentRepository;
        $this->heroAbilityRepository = $heroAbilityRepository;
        $this->entityManager = $entityManager;
    }

    public function indexAction()
    {
        $heroes = $this->heroRepository->findAll();
        return new ViewModel(
            [
                'heroes' => $heroes
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
                    'action'      => 'add',
                ]
            );
        }

        try {
            $hero = $this->heroRepository->findOneByAlias($heroAlias);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute(
                'heroes',
                [
                    'action'      => 'index',
                ]
            );
        }

        $form = new HeroForm();
        $form->bind($hero);
        $form->get('submit')->setValue('Edit');

        $request = $this->getRequest();
        $viewData = [
            'hero' => $hero,
            'form' => $form
        ];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($form->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
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
                'hero' => $hero,
                'talents' => $talents,
                'abilities' => $abilities
            ]
        );
    }
}
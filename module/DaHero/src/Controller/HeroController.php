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
        $hero->setName($formData['name'])
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
                'hero'   => strtolower(str_replace(' ', '_', $formData['name']))
            ]
        );
    }

    public function editAction()
    {
    }

    public function deleteAction()
    {
    }

    public function singleHeroAction()
    {
        $heroAlias = $this->params()->fromRoute('hero', 0);
        $heroName = ucwords(str_replace('_', ' ', $heroAlias));
        /**
         * @var $hero Hero
         */
        $hero = $this->heroRepository->findOneBy(
            [
                'name' => $heroName
            ]
        );
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
<?php

namespace DaHero\Controller;

use DaHero\Entity\Hero;
use DaHero\Entity\HeroTalent;
use DaHero\Form\HeroTalentsForm;
use DaHero\Repository\HeroRepository;
use DaHero\Repository\HeroTalentRepository;
use Doctrine\ORM\EntityManager;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class HeroTalentController extends AbstractActionController
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
     * @var EntityManager
     */
    private $entityManager;

    /**
     * TalentController constructor.
     *
     * @param $heroRepository
     * @param $heroTalentRepository
     * @param $entityManager
     */
    public function __construct(
        $heroRepository,
        $heroTalentRepository,
        $entityManager
    )
    {
        $this->heroRepository = $heroRepository;
        $this->heroTalentRepository = $heroTalentRepository;
        $this->entityManager = $entityManager;
    }

    public function indexAction()
    {
        $talents = [];

        /**
         * @var $heroes Hero[]
         */
        $heroes = $this->heroRepository->findAll();
        foreach ($heroes as $hero){
            $heroTalentsList = $this->heroTalentRepository->findTalentsByHero($hero);
            $talents[$hero->getName()] = $heroTalentsList;
        }

        return new ViewModel(
            [
                'talents' => $talents
            ]
        );
    }

    public function addHeroTalentsAction()
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
        $form = new HeroTalentsForm($hero);

        $request = $this->getRequest();

        if (!$request->isPost()) {
            return ['form' => $form];
        }

        $heroTalent = new HeroTalent();
        $form->setInputFilter($form->getInputFilter());
        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return ['form' => $form];
        }

        $formData = $form->getData();
        $heroTalent->setHero($hero)
            ->setDescription($formData['description'])
            ->setLevel($formData['level'])
            ->setDmgIncrease($formData['dmgIncrease'])
            ->setArmorIncrease($formData['armorIncrease'])
            ->setMsIncrease($formData['msIncrease'])
            ->setStrIncrease($formData['strIncrease'])
            ->setAgiIncrease($formData['agiIncrease'])
            ->setIntIncrease($formData['intIncrease'])
            ->setHpIncrease($formData['hpIncrease'])
            ->setMpIncrease($formData['mpIncrease'])
            ->setHpRegenIncrease($formData['hpRegenIncrease'])
            ->setMpRegenIncrease($formData['mpRegenIncrease']);
        $this->entityManager->persist($heroTalent);
        $this->entityManager->flush();
        //TODO redirect to hero skills
        return $this->redirect()->toRoute(
            'home'
        );
    }
}
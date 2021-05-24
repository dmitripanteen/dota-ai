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
        $postData = $request->getPost();
        $postDataSplit = [];
        foreach ($postData as $key => $value){
            $group = substr($key, -1);
            if(is_numeric($group)) {
                $postDataSplit[$group][substr($key, 0, -1)] = $value;
                $postDataSplit[$group]['hero_id'] = $postData['hero_id'];
            }
        }

        if (!$request->isPost()) {
            return ['form' => $form];
        }

        $form->setInputFilter($form->getInputFilter());
        $form->setData($postDataSplit[0]);

        if (!$form->isValid()) {
            return ['form' => $form];
        }

        foreach ($postDataSplit as $key => $postDataRes){
            $heroTalent = new HeroTalent();
            $heroTalent->setHero($hero)
                ->setDescription($postDataRes['description'])
                ->setLevel($postDataRes['level'])
                ->setDmgIncrease($postDataRes['dmgIncrease'])
                ->setArmorIncrease($postDataRes['armorIncrease'])
                ->setMsIncrease($postDataRes['msIncrease'])
                ->setStrIncrease($postDataRes['strIncrease'])
                ->setAgiIncrease($postDataRes['agiIncrease'])
                ->setIntIncrease($postDataRes['intIncrease'])
                ->setHpIncrease($postDataRes['hpIncrease'])
                ->setMpIncrease($postDataRes['mpIncrease'])
                ->setHpRegenIncrease($postDataRes['hpRegenIncrease'])
                ->setMpRegenIncrease($postDataRes['mpRegenIncrease']);
            $this->entityManager->persist($heroTalent);
            $this->entityManager->flush();
        }
        return $this->redirect()->toRoute(
            'heroes/hero-page',
            [
                'action' => 'addHeroAbilities',
                'hero'   => strtolower(str_replace(' ', '_', $heroAlias))
            ]
        );
    }
}
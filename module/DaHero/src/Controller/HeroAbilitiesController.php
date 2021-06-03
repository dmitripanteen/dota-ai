<?php

namespace DaHero\Controller;

use DaHero\Entity\Hero;
use DaHero\Entity\HeroAbility;
use DaHero\Entity\HeroTalent;
use DaHero\Form\HeroAbilitiesForm;
use DaHero\Form\HeroTalentsForm;
use DaHero\Repository\HeroAbilityRepository;
use DaHero\Repository\HeroRepository;
use Doctrine\ORM\EntityManager;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class HeroAbilitiesController extends AbstractActionController
{

    /**
     * @var HeroRepository
     */
    private $heroRepository;

    /**
     * @var HeroAbilityRepository
     */
    private $heroAbilityRepository;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * HeroAbilitiesController constructor.
     *
     * @param $heroRepository
     * @param $heroAbilityRepository
     * @param $entityManager
     */
    public function __construct(
        $heroRepository,
        $heroAbilityRepository,
        $entityManager
    ) {
        $this->heroRepository = $heroRepository;
        $this->heroAbilityRepository = $heroAbilityRepository;
        $this->entityManager = $entityManager;
    }

    public function addHeroAbilitiesAction()
    {
        $heroAlias = $this->params()->fromRoute('hero', 0);
        /**
         * @var $hero Hero
         */
        $hero = $this->heroRepository->findOneByAlias($heroAlias);
        $form = new HeroAbilitiesForm($hero);

        $request = $this->getRequest();
        $postData = $request->getPost();

        if (!$request->isPost()) {
            return ['form' => $form];
        }

        $form->setInputFilter($form->getInputFilter());
        $form->setData($postData);

        if (!$form->isValid()) {
            return ['form' => $form];
        }

        if ($postData['isUltimateAbility']) {
            $postData['abilityNumber'] = 0;
        } else {
            $postData['abilityNumber'] = (int)$postData['abilityNumber'] != 0 ? $postData['abilityNumber'] : 1;
        }

        $heroAbility = new HeroAbility();
        $heroAbility->setHero($hero)
            ->setAbilityName($postData['abilityName'])
            ->setDescription($postData['description'])
            ->setImage($postData['image'])
            ->setVideo($postData['video'])
            ->setAbilityNumber($postData['abilityNumber']);
        $this->entityManager->persist($heroAbility);
        $this->entityManager->flush();

        if ($postData['finish']) {
            return $this->redirect()->toRoute(
                'heroes/hero-page',
                [
                    'action' => 'singleHero',
                    'hero'   => $heroAlias
                ]
            );
        }
        return $this->redirect()->toRoute(
            'abilities/add-hero-abilities',
            [
                'action' => 'singleHero',
                'hero'   => $heroAlias
            ]
        );
    }
}
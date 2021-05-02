<?php

namespace DaHero\Controller;

use DaHero\Entity\Hero;
use DaHero\Repository\HeroAbilityRepository;
use DaHero\Repository\HeroRepository;
use DaHero\Repository\HeroTalentRepository;
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
     * HeroController constructor.
     *
     * @param $heroRepository
     * @param $heroTalentRepository
     * @param $heroAbilityRepository
     */
    public function __construct(
        $heroRepository,
        $heroTalentRepository,
        $heroAbilityRepository
    )
    {
        $this->heroRepository = $heroRepository;
        $this->heroTalentRepository = $heroTalentRepository;
        $this->heroAbilityRepository = $heroAbilityRepository;
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
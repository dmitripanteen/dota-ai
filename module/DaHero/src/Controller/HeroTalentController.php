<?php

namespace DaHero\Controller;

use DaHero\Entity\Hero;
use DaHero\Repository\HeroRepository;
use DaHero\Repository\HeroTalentRepository;
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
     * TalentController constructor.
     *
     * @param $heroRepository
     * @param $heroTalentRepository
     */
    public function __construct(
        $heroRepository,
        $heroTalentRepository
    )
    {
        $this->heroRepository = $heroRepository;
        $this->heroTalentRepository = $heroTalentRepository;
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
}
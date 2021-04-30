<?php

namespace DaHero\Controller;

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
        $hero = $this->heroRepository->findOneBy(
            [
                'name' => $heroName
            ]
        );
        $talents = $this->heroTalentRepository->findTalentsByHero($hero);

        return new ViewModel(
            [
                'hero' => $hero,
                'talents' => $talents
            ]
        );
    }
}
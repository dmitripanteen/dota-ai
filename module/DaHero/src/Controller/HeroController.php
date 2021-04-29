<?php

namespace DaHero\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Doctrine\Persistence\ObjectRepository;

class HeroController extends AbstractActionController
{

    /**
     * @var ObjectRepository
     */
    private $heroRepository;

    public function __construct(
        $heroRepository
    )
    {
        $this->heroRepository = $heroRepository;
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

        return new ViewModel(
            [
                'hero' => $hero
            ]
        );
    }
}
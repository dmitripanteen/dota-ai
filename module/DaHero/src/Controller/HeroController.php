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
        $heroes = $this->heroRepository
            ->findAll();

        // Render the view template
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
}
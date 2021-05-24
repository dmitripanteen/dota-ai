<?php

namespace DaHero;

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Laminas\Router\Http\Segment;

return [
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/Entity']
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ]
            ]
        ]
    ],
    'controllers' => [
        'factories' => [
            Controller\HeroController::class => Controller\Factory\HeroControllerFactory::class,
            Controller\HeroTalentController::class => Controller\Factory\HeroTalentControllerFactory::class,
            Controller\HeroAbilitiesController::class => Controller\Factory\HeroAbilitiesControllerFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'heroes' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/hero',
                    'defaults' => [
                        'controller' => Controller\HeroController::class,
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => false,
                'child_routes' => [
                    'hero-page' => [
                        'type'    => Segment::class,
                        'options' => [
                            'route'    => '/:hero',
                            'constraints' => [
                                'hero' => '[a-zA-Z_-]*',
                            ],
                            'defaults' => [
                                'controller' => Controller\HeroController::class,
                                'action'     => 'singleHero',
                            ]
                        ],
                        'may_terminate' => true,
                    ],
                    'hero-crud' => [
                        'type'    => Segment::class,
                        'options' => [
                            'route' => '/add',
                            'defaults' => [
                                'controller' => Controller\HeroController::class,
                                'action'     => 'add',
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                ]
            ],
            'talents' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/talents',
                    'defaults' => [
                        'controller' => Controller\HeroTalentController::class,
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'add-hero-talents' => [
                        'type'    => Segment::class,
                        'options' => [
                            'route'    => '/:hero/add',
                            'constraints' => [
                                'hero' => '[a-zA-Z_-]*',
                            ],
                            'defaults' => [
                                'controller' => Controller\HeroTalentController::class,
                                'action'     => 'addHeroTalents',
                            ]
                        ],
                        'may_terminate' => true,
                    ],
                ],
            ],
            'abilities' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/abilities',
                    'defaults' => [
                        'controller' => Controller\HeroAbilitiesController::class,
                    ],
                ],
                'may_terminate' =>  false,
                'child_routes' => [
                    'add-hero-abilities' => [
                        'type'    => Segment::class,
                        'options' => [
                            'route'    => '/:hero/add',
                            'constraints' => [
                                'hero' => '[a-zA-Z_-]*',
                            ],
                            'defaults' => [
                                'controller' => Controller\HeroAbilitiesController::class,
                                'action'     => 'addHeroAbilities',
                            ]
                        ],
                        'may_terminate' => true,
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'hero' => __DIR__ . '/../view',
        ],
    ],
];
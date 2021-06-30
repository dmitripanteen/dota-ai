<?php

namespace DaHero;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;

return [
    'routes' => [
        'heroes'    => [
            'type'          => Segment::class,
            'options'       => [
                'route'    => '/hero',
                'defaults' => [
                    'controller' => Controller\HeroController::class,
                    'action'     => 'index',
                ],
            ],
            'may_terminate' => true,
            'child_routes'  => [
                'hero-page' => [
                    'type'          => Segment::class,
                    'options'       => [
                        'route'       => '/:hero',
                        'constraints' => [
                            'hero' => '[a-zA-Z_-]*',
                        ],
                        'defaults'    => [
                            'controller' => Controller\HeroController::class,
                            'action'     => 'singleHero',
                        ]
                    ],
                    'may_terminate' => true,
                    'child_routes'  => [
                        'edit-hero' => [
                            'type'          => Literal::class,
                            'options'       => [
                                'route'    => '/edit',
                                'defaults' => [
                                    'controller' => Controller\HeroController::class,
                                    'action'     => 'edit',
                                ]
                            ],
                            'may_terminate' => true,
                        ],
                    ]
                ],
                'hero-crud' => [
                    'type'          => Segment::class,
                    'options'       => [
                        'route'    => '/add',
                        'defaults' => [
                            'controller' => Controller\HeroController::class,
                            'action'     => 'add',
                        ],
                    ],
                    'may_terminate' => true,
                ],
                'hero-data' => [
                    'type'          => Segment::class,
                    'options'       => [
                        'route'       => '/:heroId/data',
                        'constraints' => [
                            'heroId' => '[0-9]*',
                        ],
                        'defaults'    => [
                            'controller' => Controller\HeroController::class,
                            'action'     => 'heroData',
                        ]
                    ],
                    'may_terminate' => true,
                ],
            ]
        ],
        'hero-builder'    => [
            'type'          => Literal::class,
            'options'       => [
                'route'    => '/heroes/hero-builder',
                'defaults' => [
                    'controller' => Controller\HeroController::class,
                    'action'     => 'heroBuilder',
                ],
            ],
            'may_terminate' => true,
        ],
        'talents'   => [
            'type'          => Segment::class,
            'options'       => [
                'route'    => '/talents',
                'defaults' => [
                    'controller' => Controller\HeroTalentController::class,
                    'action'     => 'index',
                ],
            ],
            'may_terminate' => true,
            'child_routes'  => [
                'add-hero-talents'  => [
                    'type'          => Segment::class,
                    'options'       => [
                        'route'       => '/:hero/add',
                        'constraints' => [
                            'hero' => '[a-zA-Z_-]*',
                        ],
                        'defaults'    => [
                            'controller' => Controller\HeroTalentController::class,
                            'action'     => 'addHeroTalents',
                        ]
                    ],
                    'may_terminate' => true,
                ],
                'edit-hero-talents' => [
                    'type'          => Segment::class,
                    'options'       => [
                        'route'       => '/:hero/edit',
                        'constraints' => [
                            'hero' => '[a-zA-Z_-]*',
                        ],
                        'defaults'    => [
                            'controller' => Controller\HeroTalentController::class,
                            'action'     => 'editHeroTalents',
                        ]
                    ],
                    'may_terminate' => true,
                ],
            ],
        ],
        'abilities' => [
            'type'          => Segment::class,
            'options'       => [
                'route'    => '/abilities',
                'defaults' => [
                    'controller' => Controller\HeroAbilitiesController::class,
                ],
            ],
            'may_terminate' => false,
            'child_routes'  => [
                'add-hero-abilities'  => [
                    'type'          => Segment::class,
                    'options'       => [
                        'route'       => '/:hero/add',
                        'constraints' => [
                            'hero' => '[a-zA-Z_-]*',
                        ],
                        'defaults'    => [
                            'controller' => Controller\HeroAbilitiesController::class,
                            'action'     => 'addHeroAbilities',
                        ]
                    ],
                    'may_terminate' => true,
                ],
                'edit-hero-abilities' => [
                    'type'          => Segment::class,
                    'options'       => [
                        'route'       => '/:hero/edit/:abilityId',
                        'constraints' => [
                            'hero'      => '[a-zA-Z_-]*',
                            'abilityId' => '[0-9]*',
                        ],
                        'defaults'    => [
                            'controller' => Controller\HeroAbilitiesController::class,
                            'action'     => 'editHeroAbility',
                        ]
                    ],
                    'may_terminate' => true,
                ],
            ],
        ],
        'hero-stats' => [
            'type'          => Segment::class,
            'options'       => [
                'route'    => '/stats/heroes[?sort]',
                'defaults' => [
                    'controller' => Controller\HeroController::class,
                    'action'     => 'heroStats',
                ],
            ],
            'may_terminate' => true,
        ],
    ],
];
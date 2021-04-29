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
                    ]
                ]
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'hero' => __DIR__ . '/../view',
        ],
    ],
];
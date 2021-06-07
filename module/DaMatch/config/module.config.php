<?php

namespace DaMatch;

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;

return [
    'doctrine'     => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/Entity']
            ],
            'orm_default'             => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ]
            ]
        ]
    ],
    'controllers'  => [
        'factories' => [
            Controller\MatchController::class => Controller\Factory\MatchControllerFactory::class,
        ],
    ],
    'router'       => [
        'routes' => [
            'matches' => [
                'type'          => Literal::class,
                'options'       => [
                    'route'    => '/matches',
                    'defaults' => [
                        'controller' => Controller\MatchController::class,
                        'action'     => 'listMatches',
                    ],
                ],
                'may_terminate' => true,
                'child_routes'  => [
                    'match-page' => [
                        'type'          => Segment::class,
                        'options'       => [
                            'route'       => '/:matchId',
                            'constraints' => [
                                'matchId' => '[0-9]*',
                            ],
                            'defaults'    => [
                                'controller' => Controller\MatchController::class,
                                'action'     => 'showMatch',
                            ]
                        ],
                        'may_terminate' => true,
                    ],
                    'fetch'      => [
                        'type'          => Literal::class,
                        'options'       => [
                            'route'    => '/fetch',
                            'defaults' => [
                                'controller' => Controller\MatchController::class,
                                'action'     => 'fetchMatch',
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
            'match' => __DIR__ . '/../view',
        ],
    ],
];
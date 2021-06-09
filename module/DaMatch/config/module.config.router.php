<?php

namespace DaMatch;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;

return [
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
];
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
    'router'       => include __DIR__ . '/module.config.router.php',
    'view_manager' => [
        'template_path_stack' => [
            'match' => __DIR__ . '/../view',
        ],
    ],
];
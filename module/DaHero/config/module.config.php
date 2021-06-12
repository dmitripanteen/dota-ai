<?php

namespace DaHero;

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

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
            Controller\HeroController::class          => Controller\Factory\HeroControllerFactory::class,
            Controller\HeroTalentController::class    => Controller\Factory\HeroTalentControllerFactory::class,
            Controller\HeroAbilitiesController::class => Controller\Factory\HeroAbilitiesControllerFactory::class,
        ],
    ],
    'service_manager'                       => [
        'factories' => [
            Service\HeroBuilderService::class => Service\Factory\HeroBuilderServiceFactory::class
        ]
    ],
    'router'       => include __DIR__ . '/module.config.router.php',
    'view_manager' => [
        'template_path_stack' => [
            'hero' => __DIR__ . '/../view',
        ],
    ],
];
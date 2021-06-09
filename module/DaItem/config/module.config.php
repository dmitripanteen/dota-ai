<?php

namespace DaItem;

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

return [
    'doctrine'      => [
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
    'controllers'   => [
        'factories' => [
            Controller\ItemController::class        => Controller\Factory\ItemControllerFactory::class,
            Controller\NeutralItemController::class => Controller\Factory\NeutralItemControllerFactory::class,
        ],
    ],
    'form_elements' => [
        'factories' => [
            Form\ItemForm::class => Form\Factory\ItemFormFactory::class
        ],
    ],
    'router'        => include __DIR__ . '/module.config.router.php',
    'view_manager'  => [
        'template_path_stack' => [
            'item' => __DIR__ . '/../view',
        ],
    ],
];
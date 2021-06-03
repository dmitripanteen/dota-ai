<?php

namespace DaItem;

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;

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
    'router'        => [
        'routes' => [
            'items'         => [
                'type'          => Segment::class,
                'options'       => [
                    'route'    => '/items',
                    'defaults' => [
                        'controller' => Controller\ItemController::class,
                        'action'     => 'itemsList',
                    ],
                ],
                'may_terminate' => true,
                'child_routes'  => [
                    'item-page' => [
                        'type'          => Segment::class,
                        'options'       => [
                            'route'       => '/:item',
                            'constraints' => [
                                'item' => '[a-zA-Z_-]*',
                            ],
                            'defaults'    => [
                                'controller' => Controller\ItemController::class,
                                'action'     => 'singleItem',
                            ]
                        ],
                        'may_terminate' => true,
                        'child_routes'  => [
                            'edit-item' => [
                                'type'          => Literal::class,
                                'options'       => [
                                    'route'    => '/edit',
                                    'defaults' => [
                                        'controller' => Controller\ItemController::class,
                                        'action'     => 'edit',
                                    ]
                                ],
                                'may_terminate' => true,
                            ],
                        ]
                    ],
                    'add-item'  => [
                        'type'          => Literal::class,
                        'options'       => [
                            'route'    => '/add',
                            'defaults' => [
                                'controller' => Controller\ItemController::class,
                                'action'     => 'add',
                            ]
                        ],
                        'may_terminate' => true,
                    ],
                ]
            ],
            'neutral-items' => [
                'type'          => Segment::class,
                'options'       => [
                    'route'    => '/neutral-items',
                    'defaults' => [
                        'controller' => Controller\NeutralItemController::class,
                        'action'     => 'neutralItemsList',
                    ],
                ],
                'may_terminate' => true,
                'child_routes'  => [
                    'neutral-item-page' => [
                        'type'          => Segment::class,
                        'options'       => [
                            'route'       => '/:neutralItem',
                            'constraints' => [
                                'neutralItem' => '[a-zA-Z_-]*',
                            ],
                            'defaults'    => [
                                'controller' => Controller\NeutralItemController::class,
                                'action'     => 'singleItem',
                            ]
                        ],
                        'may_terminate' => true,
                        'child_routes'  => [
                            'edit-item' => [
                                'type'          => Literal::class,
                                'options'       => [
                                    'route'    => '/edit',
                                    'defaults' => [
                                        'controller' => Controller\NeutralItemController::class,
                                        'action'     => 'edit',
                                    ]
                                ],
                                'may_terminate' => true,
                            ],
                        ]
                    ],
                    'add-item'          => [
                        'type'          => Literal::class,
                        'options'       => [
                            'route'    => '/add',
                            'defaults' => [
                                'controller' => Controller\NeutralItemController::class,
                                'action'     => 'add',
                            ]
                        ],
                        'may_terminate' => true,
                    ],
                ]
            ],
        ],
    ],
    'view_manager'  => [
        'template_path_stack' => [
            'item' => __DIR__ . '/../view',
        ],
    ],
];
<?php

namespace DaItem;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;

return [
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
                'item-data' => [
                    'type'          => Segment::class,
                    'options'       => [
                        'route'       => '/data',
                        'defaults'    => [
                            'controller' => Controller\ItemController::class,
                            'action'     => 'itemData',
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
                'neutral-item-data' => [
                    'type'          => Segment::class,
                    'options'       => [
                        'route'       => '/data',
                        'defaults'    => [
                            'controller' => Controller\NeutralItemController::class,
                            'action'     => 'neutralItemData',
                        ]
                    ],
                    'may_terminate' => true,
                ],
            ]
        ],
        'item-stats' => [
            'type'          => Segment::class,
            'options'       => [
                'route'    => '/stats/items[?sort]',
                'defaults' => [
                    'controller' => Controller\ItemController::class,
                    'action'     => 'itemStats',
                ],
            ],
            'may_terminate' => true,
        ],
        'neutral-item-stats' => [
            'type'          => Segment::class,
            'options'       => [
                'route'    => '/stats/neutral-items[?sort]',
                'defaults' => [
                    'controller' => Controller\NeutralItemController::class,
                    'action'     => 'neutralItemStats',
                ],
            ],
            'may_terminate' => true,
        ],
    ],
];
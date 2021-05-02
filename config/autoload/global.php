<?php

use Doctrine\DBAL\Driver\PDO\MySQL\Driver as PDOMySqlDriver;

return [
    'doctrine' => [
        'connection'  => [
            'orm_default' => [
                'driverClass' => PDOMySqlDriver::class,
                'params'      => [
                    'host'     => '127.0.0.1',
                    'user'     => 'root',
                    'password' => '123456',
                    'dbname'   => 'dota-ai',
                ]
            ],
        ],
        'configuration' => [
            'orm_default' => [
                'generate_proxies' => true,
                'proxy_dir' => 'data/DoctrineORMModule/Proxy',
                'proxy_namespace' => 'DoctrineORMModule\Proxy',
            ],
        ],
    ],
];

<?php
return [
    'backend' => [
        'frontName' => 'admin'
    ],
    'crypt' => [
        'key' => 'da4cf6ea112c23ca6275d41a3fa7b4d3'
    ],
    'db' => [
        'table_prefix' => '',
        'connection' => [
            'default' => [
                'host' => '/opt/bitnami/mysql/tmp/mysql.sock',
                'dbname' => 'bitnami_magento',
                'username' => 'bn_magento',
                'password' => '7344bf6704',
                'model' => 'mysql4',
                'engine' => 'innodb',
                'initStatements' => 'SET NAMES utf8;',
                'active' => '1'
            ]
        ]
    ],
    'resource' => [
        'default_setup' => [
            'connection' => 'default'
        ]
    ],
    'x-frame-options' => 'SAMEORIGIN',
    'MAGE_MODE' => 'developer',
    'session' => [
        'save' => 'files'
    ],
    'cache_types' => [
        'config' => 1,
        'layout' => 1,
        'block_html' => 1,
        'collections' => 1,
        'reflection' => 1,
        'db_ddl' => 1,
        'eav' => 1,
        'customer_notification' => 1,
        'config_integration' => 1,
        'config_integration_api' => 1,
        'full_page' => 1,
        'translate' => 1,
        'config_webservice' => 1,
        'compiled_config' => 1,
        'wp_gtm_categories' => 1
    ],
    'install' => [
        'date' => 'Wed, 15 Aug 2018 10:45:07 +0000'
    ],
    'http_cache_hosts' => [
        [
            'host' => '127.0.0.1',
            'port' => '80'
        ]
    ],
    'system' => [
        'default' => [
            'dev' => [
                'debug' => [
                    'debug_logging' => '0'
                ]
            ]
        ]
    ]
];

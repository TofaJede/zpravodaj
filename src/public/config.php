<?php
/**
 * Created by PhpStorm.
 * User: krystofkosut
 * Date: 02.08.18
 * Time: 4:07
 */

return [
    'mode' => function(){
        if($_SERVER['SERVER_NAME'] == 'local.osia' || $_SERVER['SERVER_NAME'] == 'localhost'){
            return 'dev';
        }
        if($_SERVER['SERVER_NAME'] == 'zpravodaj.cz'){
            return 'production';
        }
        if($_SERVER['SERVER_NAME'] == 'zpravy.osia.cz'){
            return 'test';
        }
        return false;
    },
    'database' => [
        'dev' => [
            'host'          => 'localhost',
            'user'          => 'root',
            'password'      => '',
            'database'      => 'zpravodaj'
        ],
        'test' => [
            'host'          => 'innodb.endora.cz',
            'user'          => 'osiacz',
            'password'      => 'kokoti22',
            'database'      => 'zpravodaj'
        ],
        'production' => [
            'host'          => 'localhost',
            'user'          => 'root',
            'password'      => '',
            'database'      => 'zpravodaj'
        ]
    ],
    'dir' => [
        'dev'           => '/zpravodaj/src/public/',
        'test'          => '/public/',
        'production'    => ''
    ]
];
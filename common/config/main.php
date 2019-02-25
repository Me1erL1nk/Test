<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'db' =>  [
            'dsn' => 'mysql:host=localhost;port=3306;dbname=test',
            'username' => 'root',
            'password' => 'qwerty',
            'tablePrefix' => 'adcombo_',
            'charset' => 'utf8',
        ],
    ],
];

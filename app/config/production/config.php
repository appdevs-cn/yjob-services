<?php

/**
 * API配置
 */
$settings = array(
    'database' => array(
        'adapter' => 'Mysql',
        'host' => '127.0.0.1',
        'username' => 'apidber',
        'password' => 'ad2z2azs2',
        'name' => 'apidb',
        'port' => 3306,
        'log' => '/tmp/sql_debug',
    ),
    "redis" => [
        "host" => "localhost",
        "port" => "6379"
    ],
    'lang' => 'zh-CN',
);

return $settings;

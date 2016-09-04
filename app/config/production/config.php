<?php

/**
 * API配置
 */
$settings = array(
    'database' => array(
        'adapter' => 'Mysql',
        'host' => 'localhost',
        'username' => 'apidber',
        'password' => 'ad2z2azs2',
        'name' => 'apidb',
        'port' => 3306,
        'log' => '/tmp/sql_debug_'.date("Y-m-d", time()),
    ),
    "redis" => [
        "host" => "localhost",
        "port" => "6379"
    ],
    'lang' => 'zh-CN',
);

return $settings;

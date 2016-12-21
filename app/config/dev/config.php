<?php

/**
 * API配置
 */
$settings = array(
    'database' => array(
        'adapter' => 'Mysql',
        'host' => 'localhost',
        'username' => 'root',
        'password' => '',
        'name' => 'yservice',
        'port' => 3306,
        'log' => 'D:tmp/sql_debug',
    ),
    "redis" => [
        "host" => "localhost",
        "port" => "6379"
    ],
    'lang' => 'zh-CN',
);

return $settings;

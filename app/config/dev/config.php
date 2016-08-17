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
        'name' => 'yl-api',
        'port' => 3306
    ),
    "redis" => [
        "host" => "localhost",
        "port" => "6379"
    ]
);

return $settings;

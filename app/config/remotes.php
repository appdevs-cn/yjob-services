<?php

$txUrl = 'http://api.qq.com/';

$remotes['getToken'] = [
    'url' => 'http://www.baidu.com',
    'method' => 'post', 
    'charset' => 'UTF-8', 
];
$remotes['token'] = [
    'url' => $url.'/gettoken',
    'method' => 'post', 
    'charset' => 'UTF-8', 
];

return $remotes;
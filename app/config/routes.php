<?php

/**
 * 请求路由类配置
$routes[] = [
 	'method' => 'post', 
	'route' => '/api/update', 
	'handler' => 'myFunction'
];

 */

$routes[] = [
    'method' => 'post', 
    'route' => '/ping', 
    'handler' => ['Controllers\ExampleController', 'pingAction'],
    'authentication' => FALSE
];


$routes[] = [
    'method' => 'post', 
    'route' => '/test/{id}', 
    'handler' => ['Controllers\ExampleController', 'testAction']
];

$routes[] = [
    'method' => 'post', 
    'route' => '/skip/{name}', 
    'handler' => ['Controllers\ExampleController', 'skipAction'],
    'authentication' => FALSE
];

$routes[] = [
    'method' => 'get', 
    'route' => '/ping', 
    'handler' => ['Controllers\ExampleController', 'getAction'],
    'authentication' => FALSE
];

$routes[] = [
    'method' => 'put', 
    'route' => '/ping', 
    'handler' => ['Controllers\ExampleController', 'putAction']
];

$routes[] = [
    'method' => 'delete', 
    'route' => '/ping', 
    'handler' => ['Controllers\ExampleController', 'deleteAction']
];

$routes[] = [
    'method' => 'post',
    'route'  => '/job/create',
    'handler' => ['Controllers\JobController', 'createAction']
];

$routes[] = [
    'method' => 'post',
    'route'  => '/job/update',
    'handler' => ['Controllers\JobController', 'updateAction']
];


$routes[] = [
    'method' => 'get',
    'route'  => '/job/info',
    'handler' => ['Controllers\JobController', 'infoAction']
];

$routes[] = [
    'method' => 'post',
    'route'  => '/job/del',
    'handler' => ['Controllers\JobController', 'deleteAction']
];

$routes[] = [
    'method' => 'post',
    'route'  => '/job/list',
    'handler' => ['Controllers\JobController', 'listAction']
];


$routes[] = [
    'method' => 'post',
    'route'  => '/job/search',
    'handler' => ['Controllers\JobController', 'searchAction']
];

$routes[] = [
    'method' => 'post',
    'route'  => '/job/Refresh',
    'handler' => ['Controllers\JobController', 'RefreshAction']
];

$routes[] = [
    'method' => 'post',
    'route'  => '/job/audit',
    'handler' => ['Controllers\JobController', 'auditAction']
];

$routes[] = [
    'method' => 'post',
    'route'  => '/job/close',
    'handler' => ['Controllers\JobController', 'closeAction']
];

$routes[] = [
    'method' => 'post',
    'route'  => '/job/autoRefresh',
    'handler' => ['Controllers\JobController', 'autoRefreshAction']
];

return $routes;



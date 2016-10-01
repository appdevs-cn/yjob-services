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
    'route'  => '/job/info/{id}',
    'handler' => ['Controllers\JobController', 'infoAction']
];

$routes[] = [
    'method' => 'post',
    'route'  => '/job/delete',
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
    'route'  => '/job/refresh',
    'handler' => ['Controllers\JobController', 'refreshAction']
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

$routes[] = [
    'method' => 'post',
    'route'  => '/job/favJob',
    'handler' => ['Controllers\JobController', 'favJobAction']
];
$routes[] = [
    'method' => 'post',
    'route'  => '/job/isFav',
    'handler' => ['Controllers\JobController', 'isFavAction']
];

$routes[] = [
    'method' => 'get',
    'route'  => '/job/favlist/{uid}',
    'handler' => ['Controllers\JobController', 'favJobListAction']
];

$routes[] = [
    'method' => 'post',
    'route'  => '/job/past',
    'handler' => ['Controllers\JobController', 'pastAction']
];

$routes[] = [
    'method' => 'post',
    'route'  => '/job/pastList',
    'handler' => ['Controllers\JobController', 'pastListAction']
];

$routes[] = [
    'method' => 'post',
    'route'  => '/job/confirm',
    'handler' => ['Controllers\JobController', 'confirmAction']
];

$routes[] = [
    'method' => 'post',
    'route'  => '/job/evaluate',
    'handler' => ['Controllers\JobController', 'evaluateAction']
];

$routes[] = [
    'method' => 'get',
    'route'  => '/job/evaluateInfo/{eid}',
    'handler' => ['Controllers\JobController', 'evaluateInfoAction']
];

$routes[] = [
    'method' => 'post',
    'route'  => '/enroll/add',
    'handler' => ['Controllers\EnrollController', 'addAction']
];

$routes[] = [
    'method' => 'post',
    'route'  => '/enroll/update',
    'handler' => ['Controllers\EnrollController', 'updateAction']
];

$routes[] = [
    'method' => 'post',
    'route'  => '/enroll/status',
    'handler' => ['Controllers\EnrollController', 'statusAction']
];

$routes[] = [
    'method' => 'post',
    'route'  => '/enroll/stood',
    'handler' => ['Controllers\EnrollController', 'stoodAction']
];

$routes[] = [
    'method' => 'post',
    'route'  => '/enroll/leaveEarly',
    'handler' => ['Controllers\EnrollController', 'leaveEarlyAction']
];

$routes[] = [
    'method' => 'post',
    'route'  => '/enroll/enrollCount',
    'handler' => ['Controllers\EnrollController', 'enrollCountAction']
];

$routes[] = [
    'method' => 'post',
    'route'  => '/enroll/isEnroll',
    'handler' => ['Controllers\EnrollController', 'isEnrollAction']
];

$routes[] = [
    'method' => 'post',
    'route'  => '/enroll/list',
    'handler' => ['Controllers\EnrollController', 'listAction']
];


$routes[] = [
    'method' => 'post',
    'route'  => '/user/addResume',
    'handler' => ['Controllers\UserController', 'addResumeAction']
];

$routes[] = [
    'method' => 'post',
    'route'  => '/user/resumeInfo',
    'handler' => ['Controllers\UserController', 'resumeInfoAction']
];

$routes[] = [
    'method' => 'post',
    'route'  => '/user/resumeList',
    'handler' => ['Controllers\UserController', 'resumeListAction']
];

$routes[] = [
    'method' => 'post',
    'route'  => '/user/addIntention',
    'handler' => ['Controllers\UserController', 'addIntentionAction']
];

$routes[] = [
    'method' => 'post',
    'route'  => '/user/updateIntention',
    'handler' => ['Controllers\UserController', 'updateIntentionAction']
];

$routes[] = [
    'method' => 'post',
    'route'  => '/user/intentionInfo',
    'handler' => ['Controllers\UserController', 'intentionInfoAction']
];


$routes[] = [
    'method' => 'post',
    'route'  => '/user/authUser',
    'handler' => ['Controllers\UserController', 'authUserAction']
];

$routes[] = [
    'method' => 'post',
    'route'  => '/user/authUserList',
    'handler' => ['Controllers\UserController', 'authUserListAction']
];

$routes[] = [
    'method' => 'post',
    'route'  => '/user/authVerify',
    'handler' => ['Controllers\UserController', 'authVerifyAction']
];

$routes[] = [
    'method' => 'post',
    'route'  => '/job/jobStatistics',
    'handler' => ['Controllers\JobController', 'jobStatisticsAction']
];

$routes[] = [
    'method' => 'post',
    'route'  => '/user/reputation',
    'handler' => ['Controllers\UserController', 'reputationAction']
];

return $routes;



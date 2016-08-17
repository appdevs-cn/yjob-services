<?php

/**
 * 命名空间注册配置
 */

$autoload = [
    'Events\Api' => APP_PATH . '/library/events/api/',
    'Micro\Messages' => APP_PATH . '/library/micro/messages/',
    'Utilities\Debug' => APP_PATH . '/library/utilities/debug/',
    'Security\Hmac' => APP_PATH . '/library/security/hmac/',
    'Application' => APP_PATH . '/library/application/',
    'Interfaces' => APP_PATH . '/library/interfaces/',
    'Controllers' => APP_PATH . '/controllers/',
    'Models' => APP_PATH . '/models/',
    'REMOTE' => APP_PATH . '/remotes/'
];

return $autoload;

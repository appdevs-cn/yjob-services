<?php
define('APP_PATH', dirname(__DIR__).'/app/');

define('CONF_PATH', APP_PATH . 'config/');

define('LANG_PATH', APP_PATH . 'lang/');

define('ENV', 'production');

require APP_PATH . '/library/utilities/debug/PhpError.php';

require APP_PATH . '/library/interfaces/IRun.php';

require APP_PATH . '/library/application/Micro.php';

register_shutdown_function(['Utilities\Debug\PhpError','runtimeShutdown']);

$config = CONF_PATH .ENV. '/config.php';

$autoLoad = CONF_PATH . 'autoload.php';

$routes = CONF_PATH . 'routes.php';

use \Models\Api as Api;

try {
    $app = new Application\Micro();

    set_error_handler(['Utilities\Debug\PhpError','errorHandler']);

    $app->setAutoload($autoLoad, APP_PATH);

    $app->setConfig($config);

   // $app->setLang();

//
//    // 通过HTTP的HEADER头获取xinxi
//    $clientId = $app->request->getHeader('API_ID');
//    $time = $app->request->getHeader('API_TIME');
//    $hash = $app->request->getHeader('API_HASH');
//
//    $privateKey = Api::findFirst($clientId)->private_key;

    switch ($_SERVER['REQUEST_METHOD']) {

        case 'GET':
            $data = $_GET;
            unset($data['_url']);
            break;

        case 'POST':
            $data = $_POST;
            break;

        default:
            parse_str(file_get_contents('php://input'), $data);
            break;
    }
//
//    $message = new \Micro\Messages\Auth($clientId, $time, $hash, $data);
//
//    $app->setEvents(new \Events\Api\HmacAuthenticate($message, $privateKey));


    $app->setRoutes($routes);

    //$app->setLang();

    $app->run();

} catch(Exception $e) {

    $app->response->setStatusCode(500, "Server Error");

    $app->response->setContent($e->getMessage());

    $app->response->send();

}


<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *, Authorization');
header('Access-Control-Allow-Methods: *');
header('Access-Control-Allow-Credentials: true');
header('Content-type: json/application');

use components\Router;

ini_set('display_errors', 0);
error_reporting(E_ALL);

function myShutdown(): void
{
    if (($e = error_get_last()) !== null && $e['type'] <> E_NOTICE) {

        http_response_code(404);

        echo json_encode(array("message" => "Данного метода API не существует."), JSON_UNESCAPED_UNICODE);
    }
}

register_shutdown_function('myShutdown');

define('ROOT', dirname(__FILE__));
require_once('api/components/Autoload.php');

$router = new Router();
$router->run();
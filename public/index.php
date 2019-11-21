<?php
declare(strict_types=1);

error_reporting(-1);

require __DIR__ . '/../vendor/autoload.php';

use EPGThread\Application;
use EPGThread\Router;

var_dump($_SERVER);

$app = new Application($_GET, $_POST, $_COOKIE, $_SERVER);
$router = new Router();

$path = isset($_SERVER["PATH_INFO"]) ? $_SERVER["PATH_INFO"] : "/";
$action = $router->mapRoutingToAction($_SERVER["REQUEST_METHOD"], $path);
$app->run($action);

exit();

<?php
declare(strict_types=1);

error_reporting(-1);

ini_set("date.timezone", "Asia/Tokyo");

require __DIR__ . '/../vendor/autoload.php';

use EPGThread\Application;
use EPGThread\Router;

$app = new Application($_GET, $_POST, $_COOKIE, $_SERVER);
$router = new Router();

// 真面目にやるならREQUEST_URIパースする
$path = isset($_SERVER["PATH_INFO"]) ? $_SERVER["PATH_INFO"] : $_SERVER["REQUEST_URI"];
if (preg_match('/^\/\?/', $path, $res)) {
    $path = "/";
}
$action = $router->mapRoutingToAction($_SERVER["REQUEST_METHOD"], $path);
$response = $app->run($action);
$response->render();

exit();

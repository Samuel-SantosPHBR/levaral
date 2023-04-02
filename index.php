<?php

require_once './vendor/autoload.php';

use \App\Core\App;
use App\Core\Http\Request\Request;
use App\Core\Http\Router\Router;
use App\ExemploController;

function dd(...$mixed) {
    echo '<pre>';
    var_dump($mixed);
    echo '</pre>';
    die;
}


$routes = new Router('/solid');

$routes->get('/', function(Request $request) {
    return $request->getHttpMethod();
});

$app = new App();

$app->addRoutes($routes);
$app->execute();


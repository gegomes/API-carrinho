<?php
require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;
use Illuminate\Database\Capsule\Manager as Capsule;

error_reporting(E_ALL);
ini_set('display_errors', 1);

$app = AppFactory::create();

$capsule = new Capsule;
$capsule->addConnection([
    'driver'    => 'sqlite',
    'database'  => __DIR__ . '/../database/carrinho.sqlite',
    'prefix'    => '',
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);

(require __DIR__ . '/../src/Routes/carrinho.php')($app);

$app->run();

$app = AppFactory::create();
error_reporting(E_ALL);
ini_set('display_errors', 1);

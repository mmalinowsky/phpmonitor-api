<?php

use Api\Route\Router;
use League\Container\Container;

require_once  __DIR__.("/../Api/Bootstrap.php");

$container = new Container;
$container->add('ModuleFacade', 'Api\Module\Facade')
    ->withArgument(new Api\Module\Factory)
    ->withArgument(new Api\Module\Composite)
    ->withArgument($logger);
$container->add('FormatProcessor', 'Api\Format\Processor');
$container->add('FormatFactory', 'Api\Format\Factory');
$container->add('ControllerFactory', 'Api\Controller\Factory');
$container->add('Config', $config);
$container->add('Logger', $logger);
$container->add('Request', $request);
$router = new Router;
$router->setContainer($container);

$api = new Api\Api(
    $router
);
$api->run($request);

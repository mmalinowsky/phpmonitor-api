<?php

use Api\Route\Dispatcher;
use Api\Route\Router;
use League\Container\Container;

require_once  __DIR__.("/../Api/Bootstrap.php");

$dispatcher = FastRoute\simpleDispatcher(
    function (FastRoute\RouteCollector $r) {
        $r->addRoute(
            'GET',
            '/serverinfo/{format}[/{pingHostname:[[:alnum:].]+}]',
            [
                'controller' => 'ServerInfo',
                'method'    => 'getInfo',
            ]
        );
    }
);

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

$router = new Router;
$router->setContainer($container);

$api = new Api\Api(
    $router,
    new Dispatcher($dispatcher)
);
$api->run();

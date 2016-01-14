<?php
use Api\Route\Router as Router;
use League\Container\Container as Container;

require_once  __DIR__.("/../vendor/autoload.php");

$dispatcher = FastRoute\simpleDispatcher(
    function (FastRoute\RouteCollector $r) {

        $r->addRoute(
            'GET',
            '/get/serverinfo/{format}[/{pingHostname}]',
            [
                'controller' => 'Api\Controller\ServerInfo',
                'method'    => 'getInfo',
            ]
        );
    }
);


$container = new Container;
$container->add('ModuleFacade', 'Api\Module\Facade')
    ->withArgument(new Api\Module\Factory)
    ->withArgument(new Api\Module\Composite);
$container->add('FormatProcessor', 'Api\Format\Processor');
$container->add('FormatFactory', 'Api\Format\Factory');
$container->add('ControllerFactory', 'Api\Controller\Factory');
$container->add('Config', 'Api\Config');

$router = new Router;
$router->setContainer($container);

$api = new Api\Api(
    $router,
    new Api\Route\Dispatcher($dispatcher)
);
$api->run();

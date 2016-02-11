<?php
use Api\Route\Router;
use League\Container\Container;

require_once  __DIR__.("/../../vendor/autoload.php");

$dispatcher = FastRoute\simpleDispatcher(
    function (FastRoute\RouteCollector $r) {
        $r->addRoute(
            'GET',
            '/serverinfo/{format}[/{pingHostname:[[:alnum:].]+}]',
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
<?php
namespace Api\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Api\Route\Strategy\RouteFound;

class Router
{
    /**
     * @var \Symfony\Component\Routing\RouteCollection
     */
    private $routes;

    public function __construct()
    {
        $locator = new FileLocator(array(__DIR__.'/../'));
        $loader = new YamlFileLoader($locator);
        $this->routes = $loader->load('Routes.yml');
    }

    /**
     * @var \League\Container\Container;
     */
    private $container;

    public function setContainer($container)
    {
        $this->container = $container;
    }

    /**
     * Handle route
     *
     * @param Request $request
     */
    public function handle(Request $request)
    {
        $context = new RequestContext();
        $context->fromRequest($request);
        $matcher = new UrlMatcher($this->routes, $context);
        try {
            $attributes = $matcher->match($request->getPathInfo());
        } catch (ResourceNotFoundException $e) {
            $response = new JsonResponse();
            $response->setData(
                [
                'error' => 'Route not found.'
                ]
            );
            $response->send();
            return;
        }
        $controller = $attributes['controller'];
        $method = $attributes['method'];
        unset($attributes['method']);
        unset($attributes['controller']);
        $parameters = array_merge(['container' => $this->container], $attributes);
        $route= new RouteFound($controller, $method, $parameters);
        $route->render();
    }
}

<?php
namespace Api;

use Api\Route\Router;
use Symfony\Component\HttpFoundation\Request;

class Api
{

    /**
     * @var \Api\Route\Router
     */
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function run(Request $request)
    {
        $this->router->handle($request);
    }
}

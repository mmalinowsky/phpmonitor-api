<?php
namespace Api\Controller;

use League\Container\Container;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController
{

    public function render(Container $container, $message)
    {
        $response = new JsonResponse();
        $response->setData(
            [
            $message
            ]
        );
        $response->send();
    }
}

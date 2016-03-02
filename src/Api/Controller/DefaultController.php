<?php
namespace Api\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController
{

    public function render($message)
    {
        $response = new JsonResponse();
        $response->setData(
        [
            $message
        ]);
        $response->send();
    }
}

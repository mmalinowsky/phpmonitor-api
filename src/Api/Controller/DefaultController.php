<?php
namespace Api\Controller;

class DefaultController
{
    public function render($message)
    {
        header('Content-Type: application/json');
        echo json_encode(['error' => $message]);
    }
}

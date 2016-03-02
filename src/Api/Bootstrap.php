<?php

use Api\Config\ConfigProxy;
use Api\ErrorHandler;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Symfony\Component\HttpFoundation\Request;

require_once  __DIR__.("/../../vendor/autoload.php");

$config = new ConfigProxy('Config.json');
$environment = $config->environment;
$logger = new Logger('logger');
$logger->pushHandler(
    new StreamHandler(__DIR__.'/../logs/log.txt', Logger::WARNING)
);
$request = Request::createFromGlobals();
$errorHandler = new ErrorHandler($logger);
if ($environment == 'production') {
    set_error_handler([$errorHandler, "errorHandler"]);
    set_exception_handler([$errorHandler, "exceptionHandler"]);
}

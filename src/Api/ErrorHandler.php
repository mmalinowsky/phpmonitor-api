<?php
namespace Api;

class ErrorHandler
{

    private $logger;

    public function __construct($logger)
    {
        $this->logger = $logger;
    }

    private function buildErrorMessage($message) {
        header('Content-Type: application/json');
        die(json_encode(['error' => $message]));
    }

    public function errorHandler($level, $message, $file) {
        $this->logger->addWarning($message);
        $this->buildErrorMessage('Error occur.');
     }

    public function exceptionHandler($exception) {
        $this->logger->addWarning($exception->getMessage());
        $this->buildErrorMessage('Error occur.');
     }
}
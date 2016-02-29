<?php
namespace Api;

use Monolog\Logger;

class ErrorHandler
{
    /**
     * @var Logger
     */
    private $logger;
    /**
     * Constructor
     *
     * @param Logger $logger logger class
     */
    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }
    /**
     * Building error message
     *
     * @param string $message
     */
    private function buildErrorMessage($message) {
        header('Content-Type: application/json');
        die(json_encode(['error' => $message]));
    }
    /**
     * Handling php error
     *
     * @param integer $level error level
     * @param string $message error message
     */
    public function errorHandler($level, $message) {
        $this->logger->addWarning($message);
        $this->buildErrorMessage('Error occur.');
    }
    /**
     * Handling exceptions
     *
     * @param object $exception exception class
     */
    public function exceptionHandler($exception) {
        $this->logger->addWarning($exception->getMessage());
        $this->buildErrorMessage('Error occur.');
    }
}

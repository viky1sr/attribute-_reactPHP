<?php

namespace Jamkrindo\Lib\App;

use InvalidArgumentException;
use Monolog\Formatter\JsonFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class LoggerRequest
{
    private static $logger;

    private static function getLogger(): Logger
    {
        if (!self::$logger) {
            self::$logger = new Logger('http');
        }

        return self::$logger;
    }

    private static function createFileHandler($type): StreamHandler
    {
        $logsPath = __DIR__ . '/../../../storage/logs/' . $type . '/';

        if (!is_dir($logsPath) &&
        !mkdir($concurrentDirectory = $logsPath, 0755, true) && !is_dir($concurrentDirectory)) {
            throw new InvalidArgumentException(sprintf('Directory "%s" was not created', $concurrentDirectory));
        }

        $logsPath .= 'log_' . date('y_m_d') . '.log';

        return new StreamHandler($logsPath, Logger::INFO);
    }

    public static function logFormatJson($data, $type = 'info'): void
    {
        $allowedTypes = ['info', 'error', 'warning', 'notice', 'debug'];
        $type = strtolower($type);
        if (!in_array($type, $allowedTypes)) {
            throw new \InvalidArgumentException('Invalid log type');
        }

        $logger = self::getLogger();
        $fileHandler = self::createFileHandler('json/'.$type);
        $jsonFormatter = new JsonFormatter();
        $fileHandler->setFormatter($jsonFormatter);
        $logger->pushHandler($fileHandler);

        $logLevel = constant(Logger::class . '::' . strtoupper($type));
        $logger->log($logLevel, json_encode($data));
        $logger->popHandler();
    }

    public static function logInLine($message, $type = 'info'): void
    {
        $allowedTypes = ['info', 'error', 'warning', 'notice', 'debug'];
        $type = strtolower($type);
        if (!in_array($type, $allowedTypes)) {
            throw new \InvalidArgumentException('Invalid log type');
        }

        $logger = self::getLogger();
        $fileHandler = self::createFileHandler($type);
        $logger->pushHandler($fileHandler);

        $logLevel = constant(Logger::class . '::' . strtoupper($type));
        $logger->log($logLevel, $message);
        $logger->popHandler();
    }
}

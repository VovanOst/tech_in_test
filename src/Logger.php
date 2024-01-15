<?php

class Logger
{
    const EMERGENCY = 'emergency';
    const ALERT     = 'alert';
    const CRITICAL  = 'critical';
    const ERROR     = 'error';
    const WARNING   = 'warning';
    const NOTICE    = 'notice';
    const INFO      = 'info';
    const DEBUG     = 'debug';

    private $logLevel;

    public function __construct($logLevel = self::DEBUG)
    {
        $this->setLogLevel($logLevel);
    }

    public function setLogLevel($logLevel)
    {
        $validLogLevels = [
            self::EMERGENCY,
            self::ALERT,
            self::CRITICAL,
            self::ERROR,
            self::WARNING,
            self::NOTICE,
            self::INFO,
            self::DEBUG,
        ];

        if (!in_array($logLevel, $validLogLevels)) {
            throw new InvalidArgumentException('Invalid log level');
        }

        $this->logLevel = $logLevel;
    }

    public function log($level, $message, array $context = [])
    {
        if (array_search($level, [self::DEBUG, self::INFO, self::NOTICE, self::WARNING, self::ERROR, self::CRITICAL, self::ALERT, self::EMERGENCY]) <= array_search($this->logLevel, [self::DEBUG, self::INFO, self::NOTICE, self::WARNING, self::ERROR, self::CRITICAL, self::ALERT, self::EMERGENCY])) {
            $formattedMessage = $this->interpolate($message, $context);
            $formattedLog = sprintf("[%s] %s: %s\n", date('Y-m-d H:i:s'), strtoupper($level), $formattedMessage);
            $this->writeLog($formattedLog);
        }
    }

    private function interpolate($message, array $context)
    {
        $replace = [];
        foreach ($context as $key => $val) {
            $replace['{' . $key . '}'] = $val;
        }

        return strtr($message, $replace);
    }

    private function writeLog($formattedLog)
    {
        echo $formattedLog;
    }
}

// Пример использования
$logger = new Logger(Logger::DEBUG);

$logger->log(Logger::DEBUG, 'Debug message');
$logger->log(Logger::INFO, 'Info message');
$logger->log(Logger::WARNING, 'Warning message');
$logger->log(Logger::ERROR, 'Error message');
$logger->log(Logger::CRITICAL, 'Critical message');
$logger->log(Logger::EMERGENCY, 'Emergency message');
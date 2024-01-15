<?php
use PHPUnit\Framework\TestCase;

class LoggerTest extends TestCase
{
public function testLogLevel()
{
$logger = new Logger(Logger::DEBUG);
$this->assertEquals(Logger::DEBUG, $logger->getLogLevel());

$logger->setLogLevel(Logger::ERROR);
$this->assertEquals(Logger::ERROR, $logger->getLogLevel());
}

public function testLogMessages()
{
$logger = new Logger(Logger::DEBUG);

ob_start();
$logger->log(Logger::DEBUG, 'Debug message');
$logger->log(Logger::ERROR, 'Error message');
$logger->log(Logger::INFO, 'Info message');
$output = ob_get_clean();

$this->assertStringContainsString('Debug message', $output);
$this->assertStringContainsString('Error message', $output);
$this->assertStringNotContainsString('Info message', $output);
}


}

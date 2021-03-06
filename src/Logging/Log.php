<?php

namespace XRequestID\Logging;

use Psr\Log\LoggerInterface;
use XRequestID\Conf;

class Log implements LoggerInterface
{
    public $baseLog;
    public $app;

    public function __construct(LoggerInterface $baseLog, $app)
    {
        $this->baseLog = $baseLog;
        $this->app = $app;
    }

    public function withRequestID(array &$context)
    {
        $context[Conf::LOG_ID] = $this->app[Conf::APP_ID];
    }

    /**
     * System is unusable.
     *
     * @param string $message
     * @param mixed[] $context
     *
     * @return void
     */
    public function emergency($message, array $context = array())
    {
        $this->withRequestID($context);
        return $this->baseLog->emergency($message, $context);
    }

    /**
     * Action must be taken immediately.
     *
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     *
     * @param string $message
     * @param mixed[] $context
     *
     * @return void
     */
    public function alert($message, array $context = array())
    {
        $this->withRequestID($context);
        return $this->baseLog->alert($message, $context);
    }

    /**
     * Critical conditions.
     *
     * Example: Application component unavailable, unexpected exception.
     *
     * @param string $message
     * @param mixed[] $context
     *
     * @return void
     */
    public function critical($message, array $context = array())
    {
        $this->withRequestID($context);
        return $this->baseLog->critical($message, $context);
    }

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param string $message
     * @param mixed[] $context
     *
     * @return void
     */
    public function error($message, array $context = array())
    {
        $this->withRequestID($context);
        return $this->baseLog->error($message, $context);
    }

    /**
     * Exceptional occurrences that are not errors.
     *
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
     * @param string $message
     * @param mixed[] $context
     *
     * @return void
     */
    public function warning($message, array $context = array())
    {
        $this->withRequestID($context);
        return $this->baseLog->warning($message, $context);
    }

    /**
     * Normal but significant events.
     *
     * @param string $message
     * @param mixed[] $context
     *
     * @return void
     */
    public function notice($message, array $context = array())
    {
        $this->withRequestID($context);
        return $this->baseLog->notice($message, $context);
    }

    /**
     * Interesting events.
     *
     * Example: User logs in, SQL logs.
     *
     * @param string $message
     * @param mixed[] $context
     *
     * @return void
     */
    public function info($message, array $context = array())
    {
        $this->withRequestID($context);
        return $this->baseLog->info($message, $context);
    }

    /**
     * Detailed debug information.
     *
     * @param string $message
     * @param mixed[] $context
     *
     * @return void
     */
    public function debug($message, array $context = array())
    {
        $this->withRequestID($context);
        return $this->baseLog->debug($message, $context);
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     * @param string $message
     * @param mixed[] $context
     *
     * @return void
     *
     * @throws \Psr\Log\InvalidArgumentException
     */
    public function log($level, $message, array $context = array())
    {
        $this->withRequestID($context);
        return $this->baseLog->log($level, $message, $context);
    }

    public function __call($name, $arguments)
    {
        return $this->baseLog->{$name}(...$arguments);
    }
}
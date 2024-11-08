<?php declare(strict_types=1);

namespace interfaces\servcies\core;

use interfaces\LoggerInterface;

/**
 * LoggerUsability Interface
 *
 * @package app\common\components\interfaces
 *
 * @tag: #base #interface #usability #logger
 */
interface LoggerUsabilityInterface
{
    /**
     * @return LoggerInterface|string
     */
    public function getLoggerClass(): LoggerInterface|string;

    /**
     * @return LoggerInterface
     */
    public function getLogger(): LoggerInterface;
}
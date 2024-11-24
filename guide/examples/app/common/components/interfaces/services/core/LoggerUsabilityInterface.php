<?php declare(strict_types=1);

namespace app\common\components\interfaces\services\core;

use app\common\components\interfaces\LoggerInterface;

/**
 * LoggerUsability Interface
 *
 * @package app\common\components\interfaces\services\core
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
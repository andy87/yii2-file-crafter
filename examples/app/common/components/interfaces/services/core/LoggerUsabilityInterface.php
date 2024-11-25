<?php declare(strict_types=1);

namespace app\common\components\interfaces\services\base;

use app\common\components\interfaces\LoggerInterface;

/**
 * LoggerUsability Interface
 *
 * @package app\common\components\interfaces\services\core
 *
 * @tag: #common #interface #usability #logger
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
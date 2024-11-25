<?php declare(strict_types=1);

namespace app\common\components\interfaces;

use Exception;

/**
 * Logger Interface
 *
 * @package app\common\components\interfaces
 *
 * @tag: #common #interface #logger
 */
interface LoggerInterface
{
    /**
     * @param Exception $e
     * @param ?string $method
     * @param ?string $message
     * @param ?array $data
     *
     * @return bool
     */
    public function catcher( Exception $e, ?string $method, ?string $message, ?array $data = []): bool;
}
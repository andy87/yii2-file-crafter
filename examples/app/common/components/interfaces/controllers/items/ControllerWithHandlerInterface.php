<?php declare(strict_types=1);

namespace app\common\components\interfaces\controllers\items;

/**
 * Interface ControllerWithHandlerInterface
 *
 * @package app\common\components\interfaces\controllers\items
 *
 * @tag #common #interface #controller #handler
 */
interface ControllerWithHandlerInterface
{
    public function setupHandler(): bool;
}
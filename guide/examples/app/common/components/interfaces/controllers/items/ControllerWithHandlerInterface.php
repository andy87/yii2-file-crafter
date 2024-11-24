<?php

namespace app\common\components\interfaces\controllers\items;

/**
 * Interface ControllerWithHandlerInterface
 *
 * @package app\common\components\interfaces\controllers\items
 *
 * @tag #interface #controller #handler
 */
interface ControllerWithHandlerInterface
{
    public function setupHandler(): bool;
}
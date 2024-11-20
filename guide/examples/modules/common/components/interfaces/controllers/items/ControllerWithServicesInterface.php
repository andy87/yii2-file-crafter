<?php

namespace app\common\components\interfaces\controllers\items;

/**
 * Interface ControllerWithServicesInterface
 *
 * @package app\common\components\interfaces\controllers\items
 *
 * @property string $classnameService
 *
 * @tag #interface #controller #services
 */
interface ControllerWithServicesInterface
{
    public function setupService(): bool;
}
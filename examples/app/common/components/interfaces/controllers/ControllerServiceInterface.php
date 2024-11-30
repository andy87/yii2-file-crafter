<?php declare(strict_types=1);

namespace app\common\components\interfaces\controllers;

use app\common\components\base\services\items\BaseService;

/**
 * < Common >
 *
 * @property BaseService $service
 *
 * @package app\common\components\interfaces\controllers\items
 *
 * @tag: #abstract #common #interface #controller #service
 */
interface ControllerServiceInterface
{
    public function setupService(): bool;
}
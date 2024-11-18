<?php declare(strict_types=1);

namespace app\common\components\interfaces\services\core;

use app\common\components\base\moels\items\core\BaseModel;

/**
 * ModelUsability Interface
 *
 * @package app\common\components\interfaces\services\core
 *
 * @tag: #base #interface #usability #model
 */
interface ModelUsabilityInterface
{
    /**
     * @return BaseModel|string
     */
    public function getModelClass(): BaseModel|string;

    /**
     * @return BaseModel
     */
    public function getModel(): BaseModel;
}
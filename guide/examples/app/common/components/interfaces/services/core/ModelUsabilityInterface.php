<?php declare(strict_types=1);

namespace app\common\components\interfaces\services\base;

use app\common\components\core\moels\items\base\BaseModel;

/**
 * ModelUsability Interface
 *
 * @package app\common\components\interfaces\services\core
 *
 * @tag: #common #interface #usability #model
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
<?php declare(strict_types=1);

namespace interfaces\servcies\core;

use base\moels\items\core\BaseModel;

/**
 * ModelUsability Interface
 *
 * @package app\common\components\interfaces
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
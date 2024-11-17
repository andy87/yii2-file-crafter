<?php

namespace app\common\components\interfaces\models;

use yii\db\ActiveQueryInterface;

/**
 * Interface SearchModelInterface
 *
 * @package interfaces\models
 *
 * @tag #interface #model #search
 */
interface SearchModelInterface
{
    /**
     * @param array $params
     *
     * @return ActiveQueryInterface
     */
    public function search( array $params ): ActiveQueryInterface;
}
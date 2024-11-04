<?php

namespace andy87\yii2\file_crafter\components\models\core;

use yii\base\Model;

/**
 * Class BaseModel
 *
 * @package andy87\yii2\file_crafter\models\core
 *
 * @tag: #model #core
 */
class BaseModel extends Model
{
    /**
     * @param $data
     * @param ?string $formName
     *
     * @return bool
     */
    public function load($data, $formName = null): bool
    {
        return parent::load($data, '');
    }
}
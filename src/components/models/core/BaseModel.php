<?php

namespace andy87\yii2\dnk_file_crafter\components\models\core;

use yii\base\Model;

/**
 * Class BaseModel
 *
 * @package andy87\yii2\dnk_file_crafter\models\core
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
    public function load($data, ?string $formName = '')
    {
        return parent::load($data, $formName);
    }
}
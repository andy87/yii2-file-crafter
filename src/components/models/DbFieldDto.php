<?php

namespace andy87\yii2\dnk_file_crafter\components\models;

use andy87\yii2\dnk_file_crafter\components\models\core\BaseModel;

/**
 * Class DbField
 *
 * @package andy87\yii2\dnk_file_crafter\models
 *
 * @tag: #model #db #field
 */
class DbFieldDto extends BaseModel
{
    public string $name;
    public string $comment;
    public string $type;
    public int $size;
    public bool $foreignKeys;
    public bool $unique;

    public bool $notNull;
}
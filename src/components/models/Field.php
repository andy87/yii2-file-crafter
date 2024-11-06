<?php

namespace andy87\yii2\file_crafter\components\models;


/**
 * Class DbField
 *
 * @package andy87\yii2\file_crafter\models
 *
 * @tag: #model #db #field
 */
class Field extends \yii\base\Model
{
    public const NAME = 'name';
    public const COMMENT = 'comment';
    public const TYPE = 'type';
    public const SIZE = 'size';
    public const FOREIGN_KEYS = 'foreignKeys';
    public const UNIQUE = 'unique';
    public const NOT_NULL = 'notNull';



    public string $name;
    public string $comment;
    public string $type;
    public int $size;
    public bool $foreignKeys;
    public bool $unique;

    public bool $notNull;
}
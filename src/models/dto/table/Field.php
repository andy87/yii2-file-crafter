<?php

namespace andy87\yii2\dnk_file_crafter\models\dto\table;

/**
 *
 */
class Field
{
    public string $name;

    public string $type;

    public bool $isNullable;

    public bool $isPrimary;

    public bool $isUnique;

    public bool $isAutoIncrement;

    public string $default;

    public string $comment;



    /**
     * @param array $params
     */
    public function __construct(array $params)
    {
        foreach ($params as $key => $value) {
            $this->$key = $value;
        }
    }
}
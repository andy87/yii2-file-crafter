<?php

namespace andy87\yii2\dnk_file_crafter\models\dto\table;

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

    public Naming $naming;
}
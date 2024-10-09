<?php

namespace andy87\yii2\dnk_file_crafter\models\dto\table;

class Naming
{
    //ед.число
    public string $singular;

    //мн.число
    public string $plural;


    public function __construct( array $params )
    {
        $this->singular = $params['singular'] ?? 'n/a';

        $this->plural = $params['plural'] ?? 'n/a';
    }
}
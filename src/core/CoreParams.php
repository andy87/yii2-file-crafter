<?php

namespace andy87\yii2\dnk_file_crafter\core;

/**
 * 
 */
abstract class CoreParams
{
    /**
     * @param array $params
     */
    public function __construct(array $params = [])
    {
        foreach ($params as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * @return array
     */
    abstract public function getParams(): array;
}
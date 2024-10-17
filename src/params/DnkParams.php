<?php

namespace andy87\yii2\dnk_file_crafter\params;

use andy87\yii2\dnk_file_crafter\core\Params;

/**
 * 
 */
class DnkParams extends Params
{
    public const MAPPING = 'mapping';
    
    private array $mapping;

    /**
     * @return array[]
     */
    public function getParams(): array
    {
        return [
            self::MAPPING => $this->mapping,
        ];
    }
}
<?php declare(strict_types=1);

namespace andy87\yii2\file_crafter\components\services;

use Yii;
use andy87\yii2\file_crafter\components\core\CoreGenerator;

/**
 * Class FileProviderService
 *
 * @package andy87\yii2\file_crafter\components\services\core
 *
 * @tag: #service #file_provider
 */
class DirectoryProviderService
{
    /** @var string Default cache dir */
    public const DEFAULT_DIR = CoreGenerator::DEFAULT_RESOURCES_DIR
    . DIRECTORY_SEPARATOR . 'templates'
    . DIRECTORY_SEPARATOR . 'source';

    /** @var string Default cache ext */
    public const DEFAULT_EXT = '.tpl';



    /** @var array */
    public array $params = [];


    /**
     * @param ?array $params
     *
     * @tag #constructor
     */
    public function __construct(?array $params = null)
    {
        $this->params = $params ?? [
            'dir' => static::DEFAULT_DIR,
            'ext' => static::DEFAULT_EXT,
        ];
    }

    /**
     * Get cache dir
     *
     * @param bool $useAlias
     *
     * @return string
     */
    public function getDir(bool $useAlias = true): string
    {
        $alias = $this->params['dir'] ?? static::DEFAULT_DIR;

        return ( $useAlias ) ? Yii::getAlias($alias) : $alias;
    }

    /**
     * Get cache dir
     *
     * @return string
     */
    public function getExt(): string
    {
        return $this->params['ext'] ?? static::DEFAULT_EXT;
    }

    /**
     * @param string $fileName
     *
     * @return string
     */
    public function constructPath( string $fileName ): string
    {
        return $this->getDir() . "/$fileName"  . $this->getExt();
    }
}
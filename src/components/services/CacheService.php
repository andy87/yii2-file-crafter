<?php

namespace andy87\yii2\dnk_file_crafter\components\services;

use Yii;
use andy87\yii2\dnk_file_crafter\Crafter;

/**
 * Class CacheService
 *
 * @package andy87\yii2\dnk_file_crafter\components\services
 *
 * @tag: #service #cache
 */
class CacheService
{
    public const DEFAULT_CACHE_DIR = Crafter::RESOURCES . '/cache';
    public const DEFAULT_CACHE_EXT = '.json';



    /**
     * @var array
     */
    public array $params;


    /**
     * @param array $params
     *
     * @tag #constructor
     */
    public function __construct(array $params)
    {
        $this->params = $params;
    }

    /**
     * Get cache dir
     *
     * @return string
     */
    public function getDir(): string
    {
        $alias = $this->params['dir'] ?? self::DEFAULT_CACHE_DIR;

        return Yii::getAlias($alias);
    }

    /**
     * Get cache dir
     *
     * @return string
     */
    public function getExt(): string
    {
        return $this->params['ext'] ?? self::DEFAULT_CACHE_EXT;
    }

    /**
     * Collect all cache files
     *
     * @return array
     */
    public function getCacheFileList(): array
    {
        $list = [];

        $files = scandir($this->getDir());

        foreach ($files as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            $list[] = $file;
        }

        return $list;
    }

    /**
     * Get content from cache file
     *
     * @param mixed $tableName
     *
     * @return array
     */
    public function getContentCacheFile(mixed $tableName): array
    {
        $pathCache = $this->constructPath($tableName);

        if (file_exists($pathCache))
        {
            $content = file_get_contents($pathCache);

            if (strlen($content))
            {
                return json_decode($content, true);
            }
        }

        return [];
    }

    /**
     * Remove cache file
     *
     * @param string $remove
     *
     * @return void
     */
    public function removeItem(string $remove): void
    {
        $pathCache = $this->constructPath($remove);

        if (file_exists($pathCache))
        {
            unlink($pathCache);
        }
    }

    /**
     * @param string $name
     *
     * @return string
     */
    private function constructPath( string $name ): string
    {
        return $this->getDir() . "/$name"  . $this->params['ext'];
    }
}